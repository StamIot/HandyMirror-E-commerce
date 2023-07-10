<?php

namespace App\Controller;

use App\Entity\Product;
use App\Classes\ShoppingCart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $_session;

    public function __construct(RequestStack $requestStack)
    {
        $this->_session = $requestStack->getSession();
    }

    #[Route('/mon-panier', name: 'app_cart')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $cart = $this->_session->get('cart', []);

        $productIdS = array_keys($cart);
        $products = $entityManager
            ->getRepository(Product::class)
            ->findBy(['id' => $productIdS]);

        $subTotal = 0;

        foreach ($cart as $productId => $details) {
            foreach ($products as $product) {
                if ($product->getId() == $productId) {
                    $subTotal += ($product->getPrice() / 100) * $details['quantity_selected'];
                }
            }
        }

        return $this->render('cart/index.html.twig', [
            'titleH1' => 'Votre panier',
            'carts' => $cart,
            'products' => $products,
            'counterSession' => count($cart),
            'subTotalHT' => $subTotal,
            'subTotalTTC' => $subTotal * 1.20
        ]);
    }

    #[Route('/mon-panier/{id}/addOne', name: 'app_add_one_product')]
    public function addOneProductToCartById(Request $request, ShoppingCart $cart, $id): Response
    {
        $cart->addOneProduct($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/mon-panier/{id}/deleteOne', name: 'app_delete_one_product')]
    public function deleteOneProductToCartById(Request $request, ShoppingCart $cart, $id): Response
    {
        $cart->deleteOneProduct($id);
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]
    public function addProductToCartById(Request $request, ShoppingCart $cart, $id): Response
    {
        $cart->add($id);
        if ($request->getPathInfo() === "/mon-panier") {
            return $this->redirectToRoute('app_cart');
        } elseif ($request->getPathInfo() === "/cart/add/$id") {
            return $this->redirectToRoute('app_products_list');
        }
    }

    #[Route('/cart/clear', name: 'app_remove_to_cart')]
    public function clearAllProductsOfCart(ShoppingCart $cart): Response
    {
        $cart->clear();
        return $this->redirectToRoute('app_cart');
    }
}
