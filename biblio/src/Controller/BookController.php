<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

  /**
     * @Route("/books", name="book_")
     */
class BookController extends AbstractController
{
    /**
     * @Route("/", name="browse")
     */
    public function browse(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();

        return $this->render('book/browse.html.twig', [
            'controller_name' => 'BookController',
            'books' => $books
        ]);
    }
       /**
     * @Route("/{id}", name="read", requirements={"id":"\d+"})
     */
    public function read(Book $book)
    {
        return $this->render('book/read.html.twig', [
           'book' => $book
        ]);
    }
           /**
     * @Route("/{id}/edit", name="edit", requirements={"id":"\d+"})
     */
    public function edit(Book $book, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $book->setUpdatedAt(new \DateTime());

            $em->flush();

            return $this->redirectToRoute('book_read', ['id' => $book->getId()]);
        }

        return $this->render('book/edit.html.twig', [
           'form' => $form->createView(),
        ]);
    }
    
        /**
     * @Route("/add", name="add")
     */
    public function add(Request $request, EntityManagerInterface $em)
    {
        $book = new Book();

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('main');

        }

        return $this->render('book/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
