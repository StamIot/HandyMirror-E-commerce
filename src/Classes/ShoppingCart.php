<?php

namespace App\Classes;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ShoppingCart
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    // Ajouter un produit dans mon panier
    public function add($id) 
    {
        $this->session->set('cart', [
            [
                'id' => $id,
                'quantity' => 1
            ]
        ]);
    }

    // débuger le panier
    public function get($name)
    {
        return $this->session->get($name);
    }
}