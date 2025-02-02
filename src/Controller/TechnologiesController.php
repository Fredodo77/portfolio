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
    #[Route('technologies/new', name: 'technologies.new', methods: ['GET', 'POST'])]
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
}
