<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsListController extends AbstractController
{
    #[Route('/products/list', name: 'app_products_list')]
    public function index(): Response
    {
        return $this->render('products_list/index.html.twig', [
            'titleH1' => 'Liste des produits',
        ]);
    }
}
