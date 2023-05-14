<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService {

    private $session;
    private $productRepository;
    private $tva = 0.2;

    public function __construct(SessionInterface $session, ProductRepository $productRepository)
    {
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    // chercher le panier
    public function getCart() {
        // on fait appel au panier
        return $this->session->get('cart', []);
    }

    // mettre à jour le panier
    public function update($cart) {

        $this->session->set('cart', $cart);
        $this->session->set('cartData', $this->getFullCart());
    }

    //ajouter un product à un article dans le panier

    public function add($id) {
        $cart = $this->getCart();
        if(isset($cart[$id])) {
            //vérification si article présent dans le panier
            $cart[$id]++;
        } else {
            // dans le cas le produit n'est pas dans le panier
            $cart[$id] = 1;
        }
        $this->update($cart);
    }

    // Fonction qui créé un objet sous forme d'un tableau dans lequel se trouve les données du produits,quantité, montant

    public function getFullCart() {

        $cart = $this->getCart();
        $fullCart = [];
        $quantityCart = 0;
        $subTotal = 0;

        foreach($cart as $id => $quantity) {
            $product = $this->productRepository->find($id);
            if($product) {
                $fullCart['products'][] = [
                    'quantity' => $quantity,
                    'product' => $product,
                ];
            $quantityCart += $quantity;
            $subTotal += $quantity * $product->getPrice();

            } else {
                $this->deleteFromCart($id);
            }
        }

        // tva en propriété de la class, de sorte qu'en cas de changement, on la modifie qu'à un seul endroit
        $subTotalHT = round($subTotalTTC/(1 + $this->tva),2);
        $taxe = $subTotalTTC-$subTotalHT;

        $fullCart['data'] = [
            'quantityCart' => $quantityCart,
            'subTotalHT' => $subTotalHT,
            'taxe' => $taxe,
            'subTotalTTC' => $subTotalTTC
        ];
        

        return $fullCart;

    }

    public function deleteFromCart($id) {
        $cart = $this->getCart();
        if(isset($cart[$id])) {
            // on vérifie si la quantité de cet id est supérieure à 1
            if($cart[$id] > 1)
            // si oui, on décrémente
            $cart[$id]--;
        } else {
            // dans le cas le produit n'est pas dans le panier
            unset($cart[$id]);
        }
        $this->update($cart);
    }

    public function deleteAllCart($id) {
        // on va cherche le panier
        $cart = $this->getCart();
        // on va chercher l'id du produit
        if (isset($cart[$id])) {
            unset($cart[$id]);     
            $this->update($cart);
        }
    }

    public function deleteCart() {
        // on met à jour en mettant un tableau/panier vide
        $this->update([]);
    }
}
