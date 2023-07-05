<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductsListController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/products/list', name: 'app_products_list')]
    public function index(): Response
    {
        $allProducts = $this->entityManager->getRepository(Product::class)->findAll();
        // dd($allProducts);

        return $this->render('products_list/index.html.twig', [
            'titleH1' => 'Liste des produits',
            'products' => $allProducts
        ]);
    }
}
