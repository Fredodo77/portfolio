<?php

namespace App\Controller;

use App\Repository\CVRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\CV;
use App\Form\CVType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

final class CVController extends AbstractController
{
    #[Route('/cv', name: 'cv.index', methods: ['GET'])]
    public function index(CVRepository $repository): Response
    {
        $cv = $repository->findAll();
        return $this->render('cv/index.html.twig', [
            'cv' => $cv
        ]);
    }
    #[Route('/cv/new', name: 'cv.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cv = new CV();
        $form = $this->createForm(CVType::class, $cv);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cv = $form->getData();
            $entityManager->persist($cv);
            $entityManager->flush();
            return $this->redirectToRoute('cv.index');
        }
        return $this->render('cv/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/cv/edit/{id}', name: 'cv.edit', methods: ['GET', 'POST'])]
    public function edit(CVRepository $repository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $cv = $repository->findOneBy(['id' => $id]);
        $form = $this->createForm(CVType::class, $cv);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cv = $form->getData();
            $entityManager->flush();
            return $this->redirectToRoute('cv.index');
        }
        return $this->render('cv/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/cv/delete/{id}', name: 'cv.delete', methods: ['GET', 'POST'])]
    public function delete(CVRepository $repository, int $id, EntityManagerInterface $entityManager): Response
    {
        $cv = $repository->findOneBy(['id' => $id]);
        $entityManager->remove($cv);
        $entityManager->flush();
        return $this->redirectToRoute('cv.index');
    }
}
