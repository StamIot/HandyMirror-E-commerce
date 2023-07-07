<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use App\Classes\ShoppingCart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Length;

class CartController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/mon-panier', name: 'app_cart')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $session = $this->requestStack->getSession();
        $products = $entityManager->getRepository(Product::class)->findAll();

        $session->all();
        $countSession = count($session->all());

        return $this->render('cart/index.html.twig', [
            'titleH1' => 'Votre panier',
            'carts' => $session->get('cart'),
            'products' => $products,
            'counterSession' => $countSession
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add(ShoppingCart $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('app_products_list');
    }

    #[Route('/cart/remove', name: 'app_remove_to_cart')]
    public function remove(ShoppingCart $cart): Response
    {
        $cart->clear();
        return $this->redirectToRoute('app_cart');
    }
}
