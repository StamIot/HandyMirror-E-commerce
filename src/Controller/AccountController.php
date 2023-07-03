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
        $command = "Aucune commande pour le moment";

        $firstName = $user->getFirstname();
        $lastName = $user->getLastname();
        $email = $user->getEmail();

        // Définissez un tableau d'URLs d'images de profil
        $profileImages = [
            'images/icon1.png',
            'images/icon2.png',
            'images/icon3.png',
            'images/icon4.png',
            'images/icon5.png',
            'images/icon6.png',
            'images/icon7.png',
        ];

        // Choisissez aléatoirement une URL d'image de profil parmi le tableau
        $randomProfileImage = $profileImages[array_rand($profileImages)];

        if ($this->getUser() && in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->redirectToRoute('app_admin');
        }


        return $this->render('account/index.html.twig', [
            'titleH1' => 'Mon Compte client',
            'profileImageUrl' => $randomProfileImage,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'command' => $command,
        ]);
    }
}
