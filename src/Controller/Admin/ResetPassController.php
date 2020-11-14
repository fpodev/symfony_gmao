<?php
/*
namespace App\Controller\Admin;
Author: fpodev (fpodev@gmx.fr)
ResetPassController.php (c) 2020
Desc: description
Created:  2020-07-29T15:19:39.245Z
Modified: !date!
*/

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\ChangePasswordType;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use DateTime;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * 
 * @Route("/admin", name="admin_")
 */
class ResetPassController extends AbstractController
{
    /**
     * @Route("/reset_pass/{id}", name="reset_pass")
     */
    public function new(Users $user, MailerInterface $mailer, UserPasswordEncoderInterface $passEncode): Response
    {                       
            #Génére un mot de passe aléatoire
            $pass = substr(str_shuffle(
                'abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ0123456789/!.*-+&_$:;'),1, 10);                 
            
            $user->setPassword(
                $passEncode->encodePassword($user, $pass)
            ); 
            $user->setActivateDate(null);          
           
            $entityManager = $this->getDoctrine()->getManager();           
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from(new Address('your_reset_password@society.com', 'admin.gmao'))
                ->to($user->getEmail())
                ->subject('Rénitialisation mot de passe')
                ->htmlTemplate('users/mails/resetPassword.html.twig')
                ->context([
                    'pass' => $pass,
                    'name' => $user->getName(),
                    'firstname' => $user->getFirstname(),
                    'mail' => $user->getEmail()
                ]);

                $mailer->send($email);

            return $this->redirectToRoute('users_home');
     
      
    }
    
}
    