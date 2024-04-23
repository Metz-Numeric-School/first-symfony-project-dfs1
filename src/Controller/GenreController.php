<?php

namespace App\Controller;

use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GenreController extends AbstractController
{
    #[Route('/genres', name: 'app_genre')]
    public function index(GenreRepository $genreRepository): Response
    {
        $genres = $genreRepository->findBy([], [
            'name' => 'ASC'
        ]);

        return $this->render('genre/index.html.twig', [
            'genres' => $genres,
        ]);
    }

    #[Route('/genre/show/{id}', name: 'app_genre_show')]
    public function show(int $id, GenreRepository $genreRepository): Response
    {
        $genre = $genreRepository->find($id);
        return $this->render('genre/show.html.twig', [
            'genre' => $genre
        ]);
    }

    #[Route('/genre/new', name: 'app_genre_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(GenreType::class);
        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $genre = $form->getData();
            $em->persist($genre);
            $em->flush();

            return $this->redirectToRoute('app_genre');
        }

        return $this->render('genre/new.html.twig', [
            'genre_form' => $form->createView(),
        ]);
    }


}
