<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AuthorController extends AbstractController
{
    #[Route('/authors', name: 'app_author')]
    public function index(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findBy([],[
            'name' => 'ASC',
        ]);
        return $this->render('author/index.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/author/show/{id}', name: 'app_author_show')]
    public function show(int $id, AuthorRepository $authorRepository): Response
    {
        $author = $authorRepository->find($id);
        return $this->render('author/show.html.twig', [
            'author' => $author
        ]);
    }

    #[Route('/author/new', name: 'app_author_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AuthorType::class);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $author = $form->getData();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('app_author');
        }

        return $this->render('author/new.html.twig', [
            'author_form' => $form->createView(),
        ]);
    }

    #[Route('/author/edit/{id}', name: 'app_author_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {

        $author = $em->getRepository(Author::class)->find($id);

        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $em->flush();
            return $this->redirectToRoute('app_author');
        }

        return $this->render('author/edit.html.twig',[
            'author_form' => $form->createView(),
        ]);
    }

    #[Route('/author/delete/{id}', name: 'app_author_delete')]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $author = $em->getRepository(Author::class)->find($id);
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('app_author');
    }



}
