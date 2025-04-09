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
use Symfony\Component\Security\Http\Attribute\IsGranted;

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
    #[isGranted('ROLE_USER')]
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
    #[Route('/project/{id}', name: 'project.show', methods: ['GET'])]
    public function show(ProjectRepository $repository, int $id): Response
    {
        $project = $repository->findOneBy(['id' => $id]);
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }
    #[Route('/project/edit/{id}', name: 'project.edit', methods: ['GET', 'POST'])]
    #[isGranted('ROLE_USER')]
    public function edit(ProjectRepository $repository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = $repository->findOneBy(['id' => $id]);
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $project = $form->getData();
            $entityManager->flush();
            return $this->redirectToRoute('project.index');
        }
        return $this->render('project/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/project/delete/{id}', name: 'project.delete', methods: ['GET'])]
    #[isGranted('ROLE_USER')]
    public function delete(ProjectRepository $repository, int $id, EntityManagerInterface $entityManager): Response
    {
        $project = $repository->findOneBy(['id' => $id]);
        $entityManager->remove($project);
        $entityManager->flush();
        return $this->redirectToRoute('project.index');
    }
}
