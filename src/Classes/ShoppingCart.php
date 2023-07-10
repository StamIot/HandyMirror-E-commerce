<?php

namespace App\Classes;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class ShoppingCart
{
    private $_session;
    private $_entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack,
    ) {
        $this->_entityManager = $entityManager;
        $this->_session = $requestStack->getSession();
    }

    public function add($id)
    {
        $product = $this->_entityManager
            ->getRepository(Product::class)
            ->find($id);
        $cart = $this->_session->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]['quantity_selected']++;
            $cart[$id]['quantity_in_stock']--;
        } else {
            $cart[$id] = [
                'id' => $product->getId(),
                'slug' => $product->getSlug(),
                'quantity_selected' => 1,
                'quantity_in_stock' => $product->getQuantityInStock()
            ];
        }

        $this->_session->set('cart', $cart);
    }

    public function addOneProduct($id)
    {
        $product = $this->_entityManager
            ->getRepository(Product::class)
            ->find($id);

        // Si le produit n'est pas en stock, afficher un message d'erreur
        if ($product->getQuantityInStock() <= 0) {
            // Message flash ici
            dd("Aucun produit de ce type disponible actuellement.");
            return;
        }
        if ($product->getQuantityInStock() <= $product->getQuantitySelected()) {
            // Message flash ici
            dd("Vous ne pouvez pas sélectionner plus de " . $product->getQuantityInStock() . " produits.");
            return;
        }

        // Récupération du panier depuis la session
        $cart = $this->_session->get('cart');

        // Si le produit est déjà dans le panier, augmenter la quantité sélectionnée
        if (isset($cart[$id])) {
            $cart[$id]['quantity_selected']++;
            $cart[$id]['quantity_in_stock']--; // décrémenter la quantité en stock
        }

        // Mettre à jour le panier dans la session
        $this->_session->set('cart', $cart);
    }

    public function deleteOneProduct($id)
    {
        // Récupération du produit à partir de la base de données
        $product = $this->_entityManager->getRepository(Product::class)->find($id);

        // Récupération du panier depuis la session
        $cart = $this->_session->get('cart');

        // Si le produit est déjà dans le panier, diminuer la quantité sélectionnée
        if (isset($cart[$id])) {
            $cart[$id]['quantity_selected']--;
            $cart[$id]['quantity_in_stock']++; // incrémenter la quantité en stock

            // Si la quantité sélectionnée atteint 0, supprimer le produit du panier
            if ($cart[$id]['quantity_selected'] == 0) {
                unset($cart[$id]);
            }
        } else {
            // Si le produit n'est pas dans le panier, afficher un message d'erreur
            return;
        }

        // Mettre à jour le panier dans la session
        $this->_session->set('cart', $cart);
    }

    // public function addOne($id)
    // {
    //     $session = $this->_requestStack->getSession();
    //     $cart = $session->get('cart', []);
    //     foreach ($cart as &$item) {
    //         if ($item['id'] === $id) {
    //             $item['quantity_selected'] += 1;
    //             $item['quantity_inStock'] -= 1;
    //             break;
    //         }
    //     }
    //     $session->set('cart', $cart);
    // }

    // public function get(string $sessionName)
    // {
    //     $session = $this->_requestStack->getSession();
    //     return $session->get($sessionName);
    // }

    // public function deleteOne($id)
    // {
    //     $session = $this->_requestStack->getSession();
    //     return $session->remove($id);
    // }

    public function clear()
    {
        return $this->_session->clear();
    }
}
