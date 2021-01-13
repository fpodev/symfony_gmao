<?php

namespace App\Controller;

use App\Entity\Building;
use App\Entity\Equipement;
use App\Entity\Sector;
use App\Entity\Ville;
use App\Entity\Works;
use App\Form\BuildingType;
use App\Form\WorksType;
use App\Repository\BuildingRepository;
use App\Repository\EquipementRepository;
use App\Repository\SectorRepository;
use App\Repository\VilleRepository;
use App\Repository\WorksRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/works")
 */
class WorksController extends AbstractController
{
    /**
     * @Route("/", name="works_index", methods={"GET"})
     */
    public function index(Request $request, WorksRepository $worksRepository): Response
    {              
        return $this->render('works/index.html.twig', [
            'works' => $worksRepository->findAll(),
        ]);
    }    
    /**
     * @Route("/new", name="works_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $work = new Works();
        $session = $request->getSession();
        $session->set('ville', 'Toulouse');
       
        $work = new Works();
        $form = $this->createFormBuilder()
            ->add('title')
            ->add('description', CKEditorType::class)
            ->add('estimate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'calendar'
                ]
            ])
            ->add('ville', TextType::class, [
                'disabled' => true,
                'mapped' => false, 
                'data' => $session->get('ville')
            ])
            ->add('building', TextType::class, [
                'disabled' => true,
                'mapped' => false, 
                'data' => $session->get('building')
            ])
            ->add('sector', TextType::class, [
                'disabled' => true,
                'mapped' => false, 
                'data' => $session->get('sector')
            ]) 
            ->add('equipement', TextType::class, [
                'disabled' => true,
                'mapped' => false, 
                'data' => $session->get('equipement')
            ])
            ->add('user_request', TextType::class, [
                'disabled' => true,
                'mapped' => false, 
                'data' => $session->get('user')             
            ])
            ->getForm()
        ;     
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($work);
            $entityManager->flush();

            return $this->redirectToRoute('works_index');
        }

        return $this->render('works/new.html.twig', [
            'work' => $work,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="works_show", methods={"GET"})
     */
    public function show(Works $work): Response
    {
        return $this->render('works/show.html.twig', [
            'work' => $work,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="works_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Works $work): Response
    {
        $form = $this->createForm(WorksType::class, $work);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('works_index');
        }

        return $this->render('works/edit.html.twig', [
            'work' => $work,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="works_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Works $work): Response
    {
        if ($this->isCsrfTokenValid('delete'.$work->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($work);
            $entityManager->flush();
        }

        return $this->redirectToRoute('works_index');
    }
    
}
