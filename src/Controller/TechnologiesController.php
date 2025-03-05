<?php

namespace App\Controller;

use App\Repository\TechnologiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Technologies;
use App\Form\TechnologiesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class TechnologiesController extends AbstractController
{
    #[Route('/technologies', name: 'technologies.index', methods: ['GET'])]
    public function index(TechnologiesRepository $repository): Response
    {
        $technologies = $repository->findAll();
        return $this->render('technologies/index.html.twig', [
            'technologie' => $technologies,
        ]);
    }
    #[Route('/technologies/{id}', name: 'technologies.show', methods: ['GET'])]
    public function show(TechnologiesRepository $repository, int $id): Response
    {
        $technologies = $repository->findOneBy(['id' => $id]);
        return $this->render('technologies/show.html.twig', [
            'technologies' => $technologies,
        ]);
    }
    #[Route('technologies/new', name: 'technologies.new', methods: ['GET', 'POST'])]
    #[isGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $technologies = new Technologies();
        $form = $this->createForm(TechnologiesType::class, $technologies);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $technologies = $form->getData();
            $entityManager->persist($technologies);
            $entityManager->flush();
            return $this->redirectToRoute('technologies.index');
        }
        return $this->render('technologies/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('technologies/edit/{id}', name: 'technologies.edit', methods: ['GET', 'POST'])]
    #[isGranted('ROLE_USER')]
    public function edit(TechnologiesRepository $repository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $technologies = $repository->findOneBy(['id' => $id]);
        $form = $this->createForm(TechnologiesType::class, $technologies);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $technologies = $form->getData();
            $entityManager->flush();
            return $this->redirectToRoute('technologies.index');
        }
        return $this->render('technologies/edit.html.twig', [
            'technologies' => $form->createView()
        ]);
    }
    #[Route('technologies/delete/{id}', name: 'technologies.delete', methods: ['GET'])]
    #[isGranted('ROLE_USER')]
    public function delete(TechnologiesRepository $repository, int $id, EntityManagerInterface $entityManager): Response
    {
        $technologies = $repository->findOneBy(['id' => $id]);
        $entityManager->remove($technologies);
        $entityManager->flush();
        return $this->redirectToRoute('technologies.index');
    }
}
