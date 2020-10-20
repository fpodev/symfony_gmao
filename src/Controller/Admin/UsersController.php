<?php
/*
namespace App\Controller\Admin;
Author: fpodev (fpodev@gmx.fr)
UsersController.php (c) 2020
Desc: description
Created:  2020-07-29T15:19:39.245Z
Modified: !date!
*/

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\ChangePasswordType;
use App\Form\UsersType;
use App\Repository\UsersRepository;
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
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(Request $request, UsersRepository $usersRepository): Response    
    {      
        return $this->render('users/index.html.twig', [
            'users' => $usersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, MailerInterface $mailer, UserPasswordEncoderInterface $passEncode): Response
    {
        
        $user = new Users();
        
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            #Génére un mot de passe aléatoire
            $pass = substr(str_shuffle(
                'abcdefghijklmnopqrstuvwxyzABCEFGHIJKLMNOPQRSTUVWXYZ0123456789/!.*-+&_$:;'),1, 10);                 
            
            $user->setPassword(
                $passEncode->encodePassword($user, $pass)
            );

            $user->setCreateDate(new \DateTime('now'));
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from(new Address('create_account_gmao@society.com', 'admin.gmao'))
                ->to($user->getEmail())
                ->subject('création compte GMAO/Modification mot de passe')
                ->htmlTemplate('users/mails/createUser.html.twig')
                ->context([
                    'pass' => $pass,
                    'name' => $form->get('name')->getData(),
                    'firstname' => $form->get('firstname')->getData(),
                    'mail' => $form->get('email')->getData()
                ]);

                $mailer->send($email);

            return $this->redirectToRoute('users_home');
        }

        return $this->render('users/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Users $user): Response
    {
        return $this->render('users/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Users $user): Response
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_home');
        }

        return $this->render('users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="users_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Users $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('users_index');
    }

    
}

