<?php

namespace App\Controller;

use App\Entity\Building;
use App\Form\BuildingType;
use App\Repository\BuildingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/building", name="building_")
 */
class BuildingController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(BuildingRepository $buildingRepository): Response
    {
        return $this->render('building/index.html.twig', [
            'buildings' => $buildingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
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
     * @Route("/{id}", name="building_show", methods={"GET"})
     */
    public function show(Building $building): Response
    {
        return $this->render('building/show.html.twig', [
            'building' => $building,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="building_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Building $building): Response
    {
        $form = $this->createForm(Building1Type::class, $building);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
