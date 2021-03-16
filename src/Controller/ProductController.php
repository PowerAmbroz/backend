<?php

namespace App\Controller;

use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        $productForm = $this->createForm(ProductType::class);
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'productForm' => $productForm->createView()
        ]);
    }
}
