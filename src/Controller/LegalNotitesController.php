<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalNotitesController extends AbstractController
{
    #[Route('/legal-notites', name: 'app_legal_notites')]
    public function index(): Response
    {
        return $this->render('legal_notites/index.html.twig', [
            'titleH1' => 'Mentions Légales',
        ]);
    }
}
