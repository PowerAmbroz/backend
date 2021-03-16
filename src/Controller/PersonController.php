<?php

namespace App\Controller;

use App\Form\PersonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    /**
     * @Route("/person", name="person")
     */
    public function index(): Response
    {
        $personForm = $this->createForm(PersonType::class);

        return $this->render('person/index.html.twig', [
            'controller_name' => 'PersonController',
            'personForm' => $personForm->createView()
        ]);
    }
}
