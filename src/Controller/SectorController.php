<?php

namespace App\Controller;

use App\Entity\Building;
use App\Entity\Equipement;
use App\Entity\Sector;
use App\Form\Sector1Type;
use App\Repository\EquipementRepository;
use App\Repository\SectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sector")
 */
class SectorController extends AbstractController
{
    /**
     * @Route("/", name="sector_index", methods={"GET"})
     */
    public function index(SectorRepository $sectorRepository): Response
    {
        return $this->render('sector/index.html.twig', [
            'sectors' => $sectorRepository->findAll(),
        ]);
    }    
    /**
     * @Route("/{id}", name="sector_show", methods={"GET"})
     * @Route("/tvx/{id}", name="sector_travaux", methods={"GET"})
     */
    public function show(Sector $sector, SectorRepository $sectorRepo, Building $building, EquipementRepository $equipementRepo): Response
    {
        $uri = $_SERVER['REQUEST_URI'];     
     
        if(stristr($uri, '/tvx') == true){
            $param = 'works/demande';   
            $value = $sectorRepo->findBy(['building' => $building->getId()]);      
        }
        else{
            $param = 'sector/show';
            $value = $equipementRepo->findby(['sector' => $sector->getId()]);
        }
        return $this->render(''.$param.'.html.twig', [
            'name' => $building,
            'values' => $value,
            'path' => 'equipement_travaux'
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sector_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sector $sector): Response
    {
        $form = $this->createForm(Sector1Type::class, $sector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $equipement = new Equipement();
            $equipement->setName($form->get('equipement')->getData());
            $equipement->setSector($sector);
            $sector->getEquipements()->add($equipement);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sector_index');
        }

        return $this->render('sector/edit.html.twig', [
            'sector' => $sector,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sector_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sector $sector): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sector->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sector);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sector_index');
    }
}
