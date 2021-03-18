<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\FilterPersonType;
use App\Form\PersonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonController extends AbstractController
{
    /**
     * @Route("/person", name="person")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $filterForm = $this->createForm(FilterPersonType::class); //Dodanie formularza z filtrami

        $filterForm->handleRequest($request); // Złapanie żądania

        if($filterForm->isSubmitted() && $filterForm->isValid()){ //sprawdzenie czy formulatz został wysłany i czy jest poprawny
            $data = $filterForm->getData(); // przypisanie danych z formylarza

            $personData =  $em->getRepository(Person::class)->searchPerson($data); //pozyskanie danych opartych na tym co przesłano z formularza

            if(empty($personData)){ //sprawdzenie czy personData jest puste
                //jeśli jest puste to wypisuje komunikat oraz pobiera wszystkie dane
                $this->addFlash('danger', 'There are no records fulfilling your reguest. Showing all data.');

                $personData = $em->getRepository(Person::class)->findAll();
            }
            //tworzenie widoku
            return $this->render('person/index.html.twig', [
                'personData' => $personData,
                'filterForm' => $filterForm->createView()
            ]);
        }

        $personData = $em->getRepository(Person::class)->findAll();

        return $this->render('person/index.html.twig', [
            'personData' => $personData,
            'filterForm' => $filterForm->createView()
        ]);
    }

    /**
     * @Route ("/person/add", name="add_person")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
//    Dodawanie nowej osoby
    public function addPerson(Request $request, EntityManagerInterface $em){

        $personForm = $this->createForm(PersonType::class); //tworzenie formularza

        $personForm->handleRequest($request);

        if($personForm->isSubmitted() && $personForm->isValid()){

            $personData = $personForm->getData(); //przypisanie danych z formularza

//            Wysłanie danych do DB
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
//        Wyrzucenie informacji, że użytkownika nieznaleziono
        if (!$updatePerson) {
            throw $this->createNotFoundException(
                'Person not found'
            );
        }else{
//            Ustawienie statusu 3 dla usunietych osób
            $updatePerson->setState(3);
            $em->flush();

            $this->addFlash('success', 'Person\'s state has been changed');
        }
//        przekierowanie do strony person
        return $this->redirectToRoute('person');
    }
}
