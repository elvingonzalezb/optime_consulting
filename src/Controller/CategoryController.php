<?php

namespace App\Controller;

use App\Form\CategoryType;
use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(Request $request): Response
    {
        $category     = new Category();
        $formCategory = $this->createForm(CategoryType::class, $category);

        $entityManager = $this->getDoctrine()->getManager();
        $categorys     = $entityManager->getRepository(Category::class)->findAll();

        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted() 
            && $formCategory->isValid()
        ) {

            $nameProduct   = $entityManager->getRepository(Category::class)->findOneBy(
                                array(
                                    'name' => $formCategory->get("name")->getData()
                                ));

            if ($nameProduct ==  null) {
                
                $entityManager = $this->getDoctrine()->getManager();
                $category->setActive(true);
                $category->setCreatedAt(new \DateTime());            
                $entityManager->persist($category);
                $entityManager->flush();
                
                $this->addFlash('exito', Category::DES_MENSAJE_REGISTRO_CATEGORIA);
                return $this->redirectToroute('category');    
               
            } else {
                $this->addFlash('exito', Category::DES_MENSAJE_EXISTE_CATEGORIA);
                return $this->redirectToRoute('dashboard');
            }
     
        }

        return $this->render('category/index.html.twig', [
            'categorys'     => $categorys,
            'form_category' => $formCategory->createView()
        ]);       
    }

      /**
     * @Route("/category/edit/{id}", name="edit_category", methods={"GET","POST"})
     */
    public function editCategory(Request $request, Category $category): Response
    {
        $formCategory = $this->createForm(CategoryType::class, $category);       
        $formCategory->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $categorys     = $entityManager->getRepository(Category::class)->findAll();
            
            if ($formCategory->isSubmitted() 
                && $formCategory->isValid()
            ) {
                $this->getDoctrine()->getManager()->flush();
            
                $this->addFlash('exito', Category::DES_MENSAJE_ACTUALIZA_CATEGORIA);
                return $this->redirectToRoute('dashboard');
            }

            return $this->render('category/edit_categoria.html.twig', [
                'categorys'     => $categorys,
                'form_category' => $formCategory->createView()
            ]);            
          
    }
}
