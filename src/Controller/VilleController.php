<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Ville;
use App\Form\VilleType;
use App\Entity\Building;
use App\Form\BuildingType;
use App\Repository\VilleRepository;
use App\Repository\BuildingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/ville")
 */
class VilleController extends AbstractController
{
    public const DEFAULT_BUILDING = 'Bâtiment A';

    /**
     * @Route("/", name="ville_index", methods={"GET"})      
     */
    public function index(VilleRepository $villeRepository): Response
    {                    
            return $this->render('ville/index.html.twig', [
                'villes' => $villeRepository->findAll(),
            ]);        
    } 

    /**
     * @Route("/tvx", name="ville_tvx", methods={"GET"})
     */
    public function ville_tvx(VilleRepository $villeRepository): Response
    {
        return $this->render('works/demande.html.twig', [
            'values' => $villeRepository->findAll(),
            'name' => 'ville',
            'path' => 'building_tvx',
        ]);        
        
    }
    /**
     * @Route("/new", name="ville_new", methods={"GET","POST"})
     */
    public function new(Request $request, VilleRepository $newVille): Response
    {
        $ville = new Ville();
        $building = new Building();
        $user = new Users();
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {       

            $building->setName(self::DEFAULT_BUILDING); 
            $building->setVille($ville);
            $ville->getBuilding()->add($building);            
         
            $user = $ville->getContact();       
            $user->setVille($ville);
            $ville->getUsers()->add($user);        

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ville);       
            $entityManager->flush();

            return $this->redirectToRoute('ville_index');
        }

        return $this->render('ville/new.html.twig', [
            'ville' => $ville,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ville_show", methods={"GET"})    
     */
    public function show(Ville $ville, BuildingRepository $buildingRepo): Response
    {
        return $this->render('ville/show.html.twig', [
            'ville' => $ville,
            'building' => $buildingRepo->findBy(['ville' => $ville->getId()]),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ville_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ville $ville): Response
    {            
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);       
         
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $ville->getContact();            
            $user->setVille($ville);

            $building = new Building();                  
            $building->setName($form->get('building')->getData()); 
            $building->setVille($ville);
            $ville->getBuilding()->add($building);
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ville_index');
        }

        return $this->render('ville/edit.html.twig', [
            'ville' => $ville,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addBuilding", name="ville_addBuilding", methods={"GET","POST"})
     */
    public function addBuilding(Request $request, Ville $ville): Response
    {    
        $building = new Building();        
        $form = $this->createForm(BuildingType::class);
        $form->handleRequest($request);
       
        if ($form->isSubmitted() && $form->isValid()) {

            $building->setName($form->get('name')->getData());                     
            $building->setVille($ville);                                 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($building);       
            $entityManager->flush();

            return $this->redirectToRoute('ville_index');
        }

        return $this->render('ville/addBuilding.html.twig', [
            'ville' => $ville,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ville_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ville $ville): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ville->getId(), $request->request->get('_token'))) {
            $user = $ville->getContact();
            $user->setVille(null);            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ville);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ville_index');
    }  

    
}
