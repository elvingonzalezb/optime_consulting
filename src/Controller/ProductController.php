<?php

namespace App\Controller;

use App\Form\ProductType;
use App\Entity\Product;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product", methods={"GET","POST"})
     */
    public function index(Request $request): Response
    {
        return $this->redirectToRoute('dashboard');
    }

     /**
     * @Route("/product/create", name="new_product", methods={"GET","POST"})
     */
    public function newProduct(Request $request): Response
    {
        $product     = new Product();
        $formProduct = $this->createForm(ProductType::class, $product);

        $entityManager = $this->getDoctrine()->getManager();
        $categorys     = $entityManager->getRepository(Category::class)->findAll();

        $formProduct->handleRequest($request);

        if ($formProduct->isSubmitted() 
            && $formProduct->isValid()
        ) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->setCreatedAt(new \DateTime());            
            $entityManager->persist($product);
            $entityManager->flush();
            
            $this->addFlash('exito', Product::DES_MENSAJE_REGISTRO_PRODUCTO);
            return $this->redirectToRoute('product');
        }

        return $this->render('product/index.html.twig', [
            'categorys'    => $categorys,
            'product'      => $product,
            'form_product' => $formProduct->createView()
        ]);
    }

    /**
     * @Route("/product/{id}", name="show_product")
     */
    public function showProduct($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product       = $entityManager->getRepository(Product::class)->find($id);
       
        return $this->render('product/verproduct.html.twig', [
            'product' => $product
        ]);
    }


    /**
     * @Route("/product/edit/{id}", name="edit_product", methods={"GET","POST"})
     */
    public function editProduct(Request $request, Product $product): Response
    {
        $formProduct = $this->createForm(ProductType::class, $product);       
        $formProduct->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $categorys     = $entityManager->getRepository(Category::class)->findAll();

        if ($formProduct->isSubmitted() 
            && $formProduct->isValid()
        ) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard');
            $this->addFlash('exito', Product::DES_MENSAJE_REGISTRO_PRODUCTO);
            return $this->redirectToRoute('product');
        }

        return $this->render('product/edit_product.html.twig', [
            'categorys'    => $categorys,
            'product'      => $product,
            'form_product' => $formProduct->createView(),
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="delete_product", methods={"POST"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard');
    }
}
