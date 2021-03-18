<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\FilterProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function index(Request $request,EntityManagerInterface $em): Response
    {
        $filterForm = $this->createForm(FilterProductType::class); //Dodanie formularza z filtrami

        $filterForm->handleRequest($request);// Złapanie żądania

        if($filterForm->isSubmitted() && $filterForm->isValid()){//sprawdzenie czy formulatz został wysłany i czy jest poprawny
            $data = $filterForm->getData();// przypisanie danych z formylarza

            $productData = $em->getRepository(Product::class)->searchProduct($data);//pozyskanie danych opartych na tym co przesłano z formularza

            if(empty($productData)){//sprawdzenie czy personData jest puste
                //jeśli jest puste to wypisuje komunikat oraz pobiera wszystkie dane
                $productData = $em->getRepository(Product::class)->findAll();
            }
            //tworzenie widoku
            return $this->render('product/index.html.twig', [
                'productData' => $productData,
                'filterForm' => $filterForm->createView()
            ]);
        }

        $productData = $em->getRepository(Product::class)->findAll();
        return $this->render('product/index.html.twig', [
            'productData' => $productData,
            'filterForm' => $filterForm->createView()
        ]);
    }

    /**
     * @Route ("/product/add", name="add_product")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function addProduct(Request $request, EntityManagerInterface $em){

        $productForm = $this->createForm(ProductType::class);

        $productForm->handleRequest($request);

        if($productForm->isSubmitted() && $productForm->isValid()){

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
     * @return Response
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

        $deleteProduct = $em->getRepository(Product::class)->find($id); //znalezienie produktu do usunięcia
        $em->remove($deleteProduct); //usunięcie wybranego produktu

        $deleteLike = $em->getRepository(Like::class)->findOneBy(['product_id' => $id]); //znalezienie rekordu w tabeli Like, gdzie wystepuje poszukiwany produkt
        $em->remove($deleteLike); //usunięcie informacji z tabeli Like

        $em->flush();

        $this->addFlash('success', 'Product has been deleted');

        return $this->redirectToRoute('product');
    }
}
