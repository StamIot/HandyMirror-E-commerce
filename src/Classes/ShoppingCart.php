<?php

namespace App\Classes;

use Symfony\Component\HttpFoundation\RequestStack;

class ShoppingCart
{
    private $_requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->_requestStack = $requestStack;
    }

    public function add($id)
    {
        $session = $this->_requestStack->getSession();
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

    public function get(string $sessionName)
    {
        $session = $this->_requestStack->getSession();
        return $session->get($sessionName);
    }

    public function delete($id)
    {
        $session = $this->_requestStack->getSession();
        return $session->remove($id);
    }

    public function clear()
    {
        $session = $this->_requestStack->getSession();
        return $session->clear();
    }
}
