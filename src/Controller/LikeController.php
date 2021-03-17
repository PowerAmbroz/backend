<?php

namespace App\Controller;

use App\Entity\Like;
use App\Form\LikeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $em = $this->em();

        $likeData = $em->getRepository(Like::class)->getAllData();
//        dump($likeData);die;
        return $this->render('like/index.html.twig', [
            'controller_name' => 'LikeController',
            'likeData' => $likeData
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

            $em->persist($likeData);
            $em->flush();

            $this->addFlash('success', 'User has been added');
            return $this->redirectToRoute('like');
        }

        return $this->render('like/add.html.twig', [
            'likeForm' => $likeForm->createView()
        ]);
    }

    /**
     * @Route ("/like/edit/{id}", name="edit_like")
     * @param Like $like
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function editLike(Like $like, Request $request, EntityManagerInterface $em): Response{

        $editLike = $this->createForm(LikeType::class, $like);

        $editLike->handleRequest($request);
        if($editLike->isSubmitted() && $editLike->isValid()){

            $em->persist($like);
            $em->flush();

            $this->addFlash('success', 'Likes have been Edited');

            return $this->redirectToRoute('like');
        }

        return $this->render('/like/edit.html.twig',[
            'editLike' => $editLike->createView()
        ]);
    }
}
