<?php

namespace App\Controller;

use App\Classes\ShoppingCart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class CartController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/mon-panier', name: 'app_cart')]
    public function index(): Response
    {
        $session = $this->requestStack->getSession();

        return $this->render('cart/index.html.twig', [
            'titleH1' => 'Votre panier',
            'carts' => $session->get('cart')
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add(ShoppingCart $cart, $id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove', name: 'app_remove_to_cart')]
    public function remove(ShoppingCart $cart): Response
    {
        $cart->clear();
        return $this->redirectToRoute('app_cart');
    }
}
