<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    #[Route('/product/{id}', name: 'app_product')]
    public function index(Request $request, ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
             'titleH1' => 'Produit',
             'product' => $productRepository->find($request->get('id')),
             
        ]);
    }
}
