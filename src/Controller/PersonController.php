<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    public function em(): \Doctrine\Persistence\ObjectManager
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @Route("/person", name="person")
     */
    public function index(): Response
    {
        $em = $this->em();

        $personData = $em->getRepository(Person::class)->findAll();

        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
            'personData' => $personData
        ]);
    }

    /**
     * @Route ("/person/add", name="add_person")
     * @param Request $request
     * @return Response
     */
    public function addPerson(Request $request){

        $personForm = $this->createForm(PersonType::class);

        $personForm->handleRequest($request);

        if($personForm->isSubmitted() && $personForm->isValid()){

            $em = $this->em();
            $personData = $personForm->getData();

            $em->persist($personData);
            $em->flush();

            $this->addFlash('success', 'User has been added');
            return $this->redirectToRoute('add_person');
        }

        return $this->render('person/add.html.twig', [
            'personForm' => $personForm->createView()
        ]);
    }

    /**
     * @Route ("/person/edit/{id}", name="edit_person")
     * @param Person $person
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function editPerson(Person $person, Request $request, EntityManagerInterface $em): Response{

        $editPerson = $this->createForm(PersonType::class, $person);

        $editPerson->handleRequest($request);
        if($editPerson->isSubmitted() && $editPerson->isValid()){

            $em->persist($person);
            $em->flush();

            $this->addFlash('success', 'Person has been Edited');
        }

        return $this->render('person/edit.html.twig',[
            'editPerson' => $editPerson->createView()
        ]);
    }

    /**
     * @Route ("/person/delete/{id}", name="delete_person")
     * @param $id
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function deletePerson($id, EntityManagerInterface $em){

        $updatePerson = $em->getRepository(Person::class)->find($id);
        if (!$updatePerson) {
            throw $this->createNotFoundException(
                'Person not found'
            );
        }

        $updatePerson->setState(3);
        $em->flush();

        $this->addFlash('success', 'Person\'s state has been changed');
        return $this->redirectToRoute('person');
    }
}
