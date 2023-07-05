<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserChangeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class UserChangeController extends AbstractController
{
    #[Route('/user/change', name: 'app_user_change')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); 
        $address = $user->getAddress();
        $form = $this->createForm(UserChangeType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setAddress($address);

            $entityManager->persist($user);
            $entityManager->flush();
    
            // Redirection vers une autre page après la modification réussie
            return $this->redirectToRoute('app_account');
        }
    
        return $this->render('user_change/index.html.twig', [
            'titlePage' => 'Edition du compte',
            'form' => $form->createView(),
        ]);
    }    
}
