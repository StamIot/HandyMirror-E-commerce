<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/product/{slug}', name: 'app_product')]
    public function index($slug): Response
    {
        $productBySlug = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        // dd($productBySlug);

        if (!$productBySlug) {
            return $this->redirectToRoute('app_products_list');
        }

        return $this->render('product/index.html.twig', [
            'titleH1' => 'Produit',
            'product' => $productBySlug
        ]);
    }
}
