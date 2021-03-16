<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController'
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
}
