<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController // controller de la page A propos
{
    #[Route('/a-propos', name: 'app_about')]
    public function index(): Response
    {
        return $this->render('about/index.html.twig', [
            'titleH1' => "A propos de l'équipe",
        ]);
    }
}
