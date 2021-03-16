<?php

namespace App\Controller;

use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function em(): \Doctrine\Persistence\ObjectManager
    {
        return $this->getDoctrine()->getManager();
    }

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

    /**
     * @Route ("/product/add", name="add_product")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addProduct(Request $request){

        $productForm = $this->createForm(ProductType::class);

        $productForm->handleRequest($request);

        if($productForm->isSubmitted() && $productForm->isValid()){

            $em = $this->em();
            $productData = $productForm->getData();

            $em->persist($productData);
            $em->flush();

            $this->addFlash('success', 'User has been added');
            return $this->redirectToRoute('add_product');
        }

        return $this->render('product/add.html.twig', [
            'productForm' => $productForm->createView()
        ]);

    }
}
