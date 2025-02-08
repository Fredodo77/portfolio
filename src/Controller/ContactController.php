<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact.index', methods: ['GET'])]
    public function index(ContactRepository $repository): Response
    {
        $contact = $repository->findAll();
        return $this->render('contact/index.html.twig', [
            'contact' => $contact,
        ]);
    }
    #[Route('/contact/new', name: 'contact.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->redirectToRoute('contact.index');
        }
        return $this->render('contact/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/contact/edit/{id}', name: 'contact.edit', methods: ['GET', 'POST'])]
    public function edit(ContactRepository $repository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = $repository->findOneBy(['id' => $id]);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager->flush();
            return $this->redirectToRoute('contact.index');
        }
        return $this->render('contact/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/contact/delete/{id}', name: 'contact.delete', methods: ['GET'])]
    public function delete(ContactRepository $repository, int $id, EntityManagerInterface $entityManager): RedirectResponse
    {
        $contact = $repository->findOneBy(['id' => $id]);
        $entityManager->remove($contact);
        $entityManager->flush();
        return $this->redirectToRoute('contact.index');
    }
}
