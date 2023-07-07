<?php

namespace App\Classes;

use Symfony\Component\HttpFoundation\RequestStack;

class ShoppingCart
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function add($id)
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        
        // Vérifier si l'élément existe déjà dans le panier
        $existingItem = null;
        foreach ($cart as &$item) {
            if ($item['id'] === $id) {
                $existingItem = $item;
                break;
            }
        }

        if ($existingItem !== null) {
            // Si l'élément existe déjà, augmenter la quantité
            $existingItem['quantity'] += 1;
        } else {
            // Sinon, ajouter un nouvel élément au panier
            $cart[] = [
                'id' => $id,
                'quantity' => 3
            ];
        }

        $session->set('cart', $cart);
    }

    public function get(string $name)
    {
        $session = $this->requestStack->getSession();
        return $session->get($name);
    }

    public function clear()
    {
        $session = $this->requestStack->getSession();
        return $session->clear();
    }
}
