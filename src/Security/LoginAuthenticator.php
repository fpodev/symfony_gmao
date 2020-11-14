<?php

namespace App\Security;

use App\Entity\Users;
use App\Entity\LoginAttempt;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\LoginAttemptRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class LoginAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;
    private $loginAttemptRepository;
    private $mailer;
  

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder, LoginAttemptRepository $loginAttemptRepository, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
        $this->loginAttemptRepository = $loginAttemptRepository;  
        $this->mailer = $mailer;          
    }

    public function supports(Request $request)
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );       
                
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->entityManager->getRepository(Users::class)->findOneBy(['email' => $credentials['email']]);
                     
            if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Identifiant non trouvé.');
        }
        $session = new Session();
        $session->set('id', $user->getId());
        
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {   
            
            if ($this->loginAttemptRepository->countRecentLoginAttempts($credentials['email']) == 3) {
                $mail = $credentials['csrf_token'];
                $this->loginAttemptMail($credentials, $user); 
                $this->loginAttemptCompt($credentials['email'], $mail); 
                throw new CustomUserMessageAuthenticationException('Vous avez essayé de vous connecter avec un mot'
                    .' de passe incorrect de trop nombreuses fois. Veuillez patienter svp avant de ré-essayer.');
                                    
        }else{    
            $mail = '';         
            $this->loginAttemptCompt($credentials['email'], $mail);      
        }
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function getPassword($credentials): ?string
    {        
        return $credentials['password'];
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
       
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }
        
        return new RedirectResponse($this->urlGenerator->generate('users_home'));
        //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);

    }
    public function loginAttemptMail($credentials, $user)
    {   
        
        $email = (new TemplatedEmail())
            ->from(new Address('security_accompt@society.com', 'security.gmao'))
            ->to($credentials['email'])
            ->subject('Alerte sécurité compte GMAO')
            ->htmlTemplate('users/mails/alertAccompt.html.twig')
            ->context([            
                'name' => $user->getName(),
                'firstname' => $user->getFirstName(),
                'id'=> $user->getId(),
                'token' => $credentials['csrf_token']             
            ]);

        $this->mailer->send($email);
       ;
    }
    public function loginAttemptCompt($credentials, $mail)
    {
        $newLoginAttempt = new LoginAttempt('');
        if($mail != null){
            $newLoginAttempt->setToken($mail);
        }        
        $newLoginAttempt->setUsername($credentials);
        
        $this->entityManager->persist($newLoginAttempt);
        $this->entityManager->flush(); 
    }
    
    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
