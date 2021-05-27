<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $user= $this->getUser();

        if(!$user) {
            return $this->redirectToRoute('app_login');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $categorys     = $entityManager->getRepository(Category::class)->findAll();
        $query         = $entityManager->getRepository(Product::class)->findAllProducts();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), 
            3
        );

        return $this->render('dashboard/index.html.twig', [
            'categorys'  => $categorys,
            'pagination' => $pagination
        ]);
    }
}
