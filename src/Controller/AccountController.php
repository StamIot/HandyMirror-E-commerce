<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        $user = $this->getUser();
        // dd($user);
        $command = "Aucune commande pour le moment";

        $profileImages = [
            'images/icons/user/icon1.png',
            'images/icons/user/icon2.png',
            'images/icons/user/icon3.png',
            'images/icons/user/icon4.png',
            'images/icons/user/icon5.png',
            'images/icons/user/icon6.png',
            'images/icons/user/icon7.png',
        ];

        $randomProfileImage = $profileImages[array_rand($profileImages)];

        if ($user && in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->redirectToRoute('app_admin');
        } elsif (!$user) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('account/index.html.twig', [
            'titleH1' => 'Mon Compte client',
            'profileImageUrl' => $randomProfileImage,
            'command' => $command,
        ]);
    }
}
