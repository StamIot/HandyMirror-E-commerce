<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FAQController extends AbstractController
{
    #[Route('/faq', name: 'app_faq')] // route pour la FAQ
    public function index(): Response
    {
        return $this->render('faq/index.html.twig', [ // renvoie vers la page FAQ
            'controller_name' => 'FAQController',
        ]);
    }
}
