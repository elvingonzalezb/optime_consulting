<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user     = new User();
        $formUser = $this->createForm(UserType::class, $user);

        $formUser->handleRequest($request);

        if ($formUser->isSubmitted() 
            && $formUser->isValid()
        ) {

            $entityManager = $this->getDoctrine()->getManager();
              
            $emailUser = $entityManager->getRepository(User::class)->findOneBy(
                array(
                    'email' => $formUser->get("email")->getData()
                ));

            if ($emailUser ==  null) {                
                $user->setPassword($passwordEncoder->encodePassword($user, $formUser['password']->getData()));
                $entityManager->persist($user);
                $entityManager->flush();
                
                $this->addFlash('exito', User::DES_MENSAJE_REGISTRO_EXITOSO);
                return $this->redirectToroute('registro');

            } else {
                $this->addFlash('exito', 'Email ya se encuentra registrado');
                return $this->redirectToRoute('registro');
            }
        }

        return $this->render('registro/index.html.twig', [
            'controller_name' => 'RegistroController',
            'form_user'      => $formUser->createView()
        ]);
    }
}
