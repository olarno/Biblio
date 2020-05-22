<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

    /**
     * @Route("/person", name="person_")
     */
class PersonController extends AbstractController
{
        /**
     * @Route("/", name="browse")
     */

    public function index(PersonRepository $personRepository)
    {
        $people = $personRepository->findAll();
        return $this->render('person/index.html.twig', [
         'people' => $people,
        ]);
    }

            /**
     * @Route("/add", name="add")
     */

    public function add(Request $request, EntityManagerInterface $em)
    {
        $person = new Person();

        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($person);
            $em->flush();

            return $this->redirectToRoute('main');
        }
       
        return $this->render('person/add.html.twig', [
         'form' => $form->createView(),
        ]);
    }
}
