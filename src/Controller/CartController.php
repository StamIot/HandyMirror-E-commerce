<?php

namespace App\Controller;

use App\Classes\ShoppingCart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(ShoppingCart $cart): Response
    {
        // dd($cart->get('cart'));

        return $this->render('cart/index.html.twig', [
            'titleH1' => 'Votre panier',
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function add(ShoppingCart $cart, $id): Response
    {
        // $cart->add($id);

        return $this->render('cart/index.html.twig', [
            'titleH1' => 'Votre panier',
        ]);
    }
}
