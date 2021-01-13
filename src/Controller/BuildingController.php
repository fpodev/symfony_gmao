<?php

namespace App\Controller;

use App\Entity\Sector;
use App\Entity\Building;
use App\Entity\Ville;
use App\Form\Sector1Type;
use App\Form\BuildingType;
use App\Repository\BuildingRepository;
use App\Repository\SectorRepository;
use App\Repository\VilleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/building")
 */
class BuildingController extends AbstractController
{
    /**
     * @Route("/", name="building_index", methods={"GET"})
     * 
     */
    public function index(BuildingRepository $buildingRepo): Response
    {
               
        return $this->render('building/index.html.twig', [
            'buildings' => $buildingRepo->findAll(),
            
        ]);
    }

    /**
     * @Route("/new", name="building_new", methods={"GET","POST"})
     */
    public function new(Request $request, BuildingRepository $build): Response
    {
        $building = new Building();        
        $form = $this->createForm(BuildingType::class, $building);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($building);
            $entityManager->flush();

            return $this->redirectToRoute('building_index');
        }

        return $this->render('building/new.html.twig', [
            'building' => $building,
            'form' => $form->createView(),
        ]);
    }

    /**
     *@Route("/tvx/{id}", name="building_tvx", methods={"GET"})
     */
    public function tvx(Request $request, ville $ville, BuildingRepository $buildingRepo): Response
    {
        return $this->render('works/demande.html.twig', [
            'values' => $buildingRepo->findBy(['ville' => $ville->getId()]),
            'name' => 'Bâtiments',
            'path' => 'sector_travaux'
        ]);
    }
    
    /**
     * @Route("/{id}/addSector", name="sector_add", methods={"GET","POST"})
     */
    public function addSector(Request $request, Building $building): Response
    {

        $sector = new Sector();
        $form = $this->createForm(Sector1Type::class, $sector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sector->setName($form->get('name')->getData());                     
            $sector->setBuilding($building);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sector);
            $entityManager->flush();

            return $this->redirectToRoute('building_index');
        }

        return $this->render('building/addSector.html.twig', [
            'sector' => $sector,
            'building' => $building,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="building_show", methods={"GET"})     
     */
    public function show(Building $building, SectorRepository $sectorRepo): Response
    {
            return $this->render('building/show.html.twig', [
             'building' => $building,
             'secteurs' => $sectorRepo->findBy(['building' => $building->getId()]),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="building_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Building $building): Response
    {
        $form = $this->createForm(BuildingType::class, $building);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $sector = new Sector();
            $sector->setName($form->get('sector')->getData());            
            $sector->setBuilding($building);   
            $building->getSectors()->add($sector);
          
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('building_index');
        }

        return $this->render('building/edit.html.twig', [
            'building' => $building,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="building_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Building $building): Response
    {
        if ($this->isCsrfTokenValid('delete'.$building->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($building);
            $entityManager->flush();
        }

        return $this->redirectToRoute('building_index');
    }
}
