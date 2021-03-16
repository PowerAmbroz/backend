<?php

namespace App\Controller;

use App\Form\LikeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    /**
     * @Route("/like", name="like")
     */
    public function index(): Response
    {
        $likeForm = $this->createForm(LikeType::class);
        return $this->render('like/index.html.twig', [
            'controller_name' => 'LikeController',
            'likeForm' => $likeForm->createView()
        ]);
    }
}
