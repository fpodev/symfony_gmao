<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Form\ChangePasswordType;
use App\Repository\LoginAttemptRepository;
use App\Repository\UsersRepository;
use DateTime;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/users", name="users_")
 */
class UsersController extends AbstractController
{
    public const LENGTH_PASS = 10;
    public const FROM_MAIL_ADRESS = 'create_account_gmao@society.com';
    public const FROM_NAME_MAIL = 'admin.gmao';
    public const SUBJECT_MAIL = 'création compte GMAO';

    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(Request $request, UsersRepository $usersRepository, LoginAttemptRepository $loginAttemptReposity): Response
    {   
        $session = $request->getSession();

        $user = $usersRepository->findOneBy(['id' => $session->get('id')]); 
        $entityManager = $this->getDoctrine()->getManager();

            $loginAttempt = $loginAttemptReposity->findBy(['username' => $user->getEmail()]);
            foreach ($loginAttempt as $key) {
                $entityManager->remove($key);            
               };               
            
            $entityManager->flush();

        $today = new DateTime('now');        
        $actived = $user->getActivateDate(); 
        $valid = $actived ? $actived : $today;
        $duration = $today->diff($valid);        
        $expired = $duration->format('%a');        
      
        if($actived == null || $expired >= '30'){           
            $form = $this->createForm(ChangePasswordType::class);                                       
            
             return $this->render('change_password/index.html.twig',[
                 'user' => $user,
                 'valid' => $valid,
                 'form' => $form->createView()
             ]);
        }else{
            return $this->render('users/home.html.twig', [
                'expired' => $expired,
            ]);
        }            
    }

    /**
     *
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer, UserPasswordEncoderInterface $passEncode, Users $user ): Response
    {    
        $user = new Users();     
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);
           
        if ($form->isSubmitted() && $form->isValid()) {
            #Génére un mot de passe aléatoire
            $pass = substr(str_shuffle(
                'abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ0123456789/!.*-+&_$:;'),1, self::LENGTH_PASS);                 
            
            $user->setPassword(
                $passEncode->encodePassword($user, $pass)
            );
            $user->setCreateDate(new \DateTime('now'));
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from(new Address(self::FROM_MAIL_ADRESS, self::FROM_NAME_MAIL))
                ->to($user->getEmail())
                ->subject(self::SUBJECT_MAIL)
                ->htmlTemplate('users/mails/createUser.html.twig')
                ->context([
                    'pass' => $pass,
                    'name' => $form->get('name')->getData(),
                    'firstname' => $form->get('firstname')->getData(),
                    'mail' => $form->get('email')->getData()
                ]);

                $mailer->send($email);

            return $this->redirectToRoute('users_index');
        }else{
            return $this->render('users/new.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }        
    }

    /**
     * @Route("/{id}", name="_show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="users_edit", methods={"POST"})
     */
    public function edit(Request $request, Users $user): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_home');
        }else{
            return $this->render('users/edit.html.twig', [
                'user' => $user,
                'form' => $form->createView(),
            ]);
        }        
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     */
    public function delete(Request $request, Users $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $ville = $user->getVille();
            $ville->setContact(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('users_home');
    }
     /**
     * @Route("/change/{id<[0-9]+>}", name="change")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passEncode): Response  
    {            
        if($request->isMethod('POST')) { 
            $post = $request->request;            
           
           foreach ($post as $key) {               
            $value = $key['new_password'] ;
            $pass = $key['password'];             
           };    
        }   
           $user = $this->getUser();          
              
            if($passEncode->isPasswordValid($user, $pass) && $value['first'] === $value['second']) {                
                    $user->setPassword($passEncode->encodePassword($user, $value['first']));
                    $user->setActivateDate(new \DateTime('now'));
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();

                    $this->addFlash('valid', 'Vous avez bien modifié votre mot de passe');                    
                    return $this->redirectToRoute('users_home');
                }else{ 

                    $this->addFlash('erreur', 'Votre ancien mot de passe ou la réptition du nouveau du mot de passe sont faux. Veuillez réessayer');                    
            
                    return $this->redirectToRoute('users_home');    
               
                }
    }
    
}
