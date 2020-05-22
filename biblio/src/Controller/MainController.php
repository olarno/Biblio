<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(BookRepository $bookRepository, PersonRepository $personRepository)
    {
        $books = $bookRepository->findBy([],['id' => 'DESC'], 5);
        $people = $personRepository->findBy([], ['id' => 'DESC'], 5);

        return $this->render('main/index.html.twig', [
            'books' => $books,
            'people' => $people,
        ]);
    }
}
