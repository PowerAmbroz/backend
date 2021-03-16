<?php

namespace App\Controller;

use App\Form\LikeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    public function em(): \Doctrine\Persistence\ObjectManager
    {
        return $this->getDoctrine()->getManager();
    }

    /**
     * @Route("/like", name="like")
     */
    public function index(): Response
    {
        return $this->render('like/index.html.twig', [
            'controller_name' => 'LikeController'
        ]);
    }

    /**
     * @Route ("/like/add", name="add_like")
     * @param Request $request
     * @return Response
     */
    public function addLike(Request $request): Response
    {

        $likeForm = $this->createForm(LikeType::class);

        $likeForm->handleRequest($request);

        if($likeForm->isSubmitted() && $likeForm->isValid()){

            $em = $this->em();
            $likeData = $likeForm->getData();

//            dump($likeData);die;
            $em->persist($likeData);
            $em->flush();

            $this->addFlash('success', 'User has been added');
            return $this->redirectToRoute('add_person');
        }

        return $this->render('like/add.html.twig', [
            'likeForm' => $likeForm->createView()
        ]);
    }
}
