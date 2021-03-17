<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
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
        $em = $this->em();

        $productData = $em->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'productData' => $productData
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

    /**
     * @Route ("/product/edit/{id}", name="edit_product")
     * @param Product $product
     * @param Request $request
     * @param EntityManagerInterface $em
     */
    public function editProduct(Product $product, Request $request, EntityManagerInterface $em): Response{

        $editProduct = $this->createForm(ProductType::class, $product);

        $editProduct->handleRequest($request);
        if($editProduct->isSubmitted() && $editProduct->isValid()){

            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Product has been Edited');
        }
        return $this->render('/product/edit.html.twig',[
            'editProduct' => $editProduct->createView()
        ]);
    }

    /**
     * @Route ("/product/delete/{id}", name="delete_product")
     * @param $id
     * @param EntityManagerInterface $em
     * @return RedirectResponse
     */
    public function deleteProduct($id, EntityManagerInterface $em){

        $deleteProduct = $em->getRepository(Product::class)->find($id);
        $em->remove($deleteProduct);

        $deleteLike = $em->getRepository(Like::class)->findOneBy(['product_id' => $id]);
        $em->remove($deleteLike);

        $em->flush();

        $this->addFlash('success', 'Product has been deleted');

        return $this->redirectToRoute('product');
    }
}
