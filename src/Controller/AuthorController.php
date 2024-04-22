<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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

    #[Route('/author/{id}', name: 'app_author_show')]
    public function show(int $id, AuthorRepository $authorRepository): Response
    {
        $author = $authorRepository->find($id);
        return $this->render('author/show.html.twig', [
            'author' => $author
        ]);
    }

    public function new(): Response
    {
        return $this->render('author/new.html.twig');
    }

    public function edit(): Response
    {
        return $this->render('author/edit.html.twig');
    }

    // public function delete(): Response
    // {
    //     return 
    // }



}
