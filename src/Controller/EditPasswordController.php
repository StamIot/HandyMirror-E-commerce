<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditPasswordController extends AbstractController
{
    #[Route('/edit/password', name: 'app_edit_password')]
    public function index(): Response
    {
        return $this->render('edit_password/index.html.twig', [
            'controller_name' => 'EditPasswordController',
        ]);
    }
}
