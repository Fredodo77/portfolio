<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Project;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;

final class ProjectController extends AbstractController
{
    #[Route('/project', name: 'project.index', methods: ['GET'])]
    public function index(ProjectRepository $repository): Response
    {
        $project = $repository->findAll();
        return $this->render('project/index.html.twig', [
            'project' => $project,
        ]);
    }
    #[Route('/project/new', name: 'project.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $project = $form->getData();
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('project.index');
        }
        return $this->render('project/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
