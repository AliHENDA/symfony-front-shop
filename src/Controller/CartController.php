<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\TypeRepository;
use App\Service\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $cartService;

    public function __construct(CartService $cartService) {

        $this->cartService = $cartService;
    }
    /**
     * @Route("/panier", name="app_cart")
     */
    public function cart(TypeRepository $typeRepository, BrandRepository $brandRepository, CategoryRepository $categoryRepository): Response
    {
        $cart = $this->cartService->getFullCart();
        // if(!isset($cart['products'])){
        //     return $this->redirectToRoute('app_main_home'); 
        // }
        // dd($cart['data']);
        $categories = $categoryRepository->findAll();
        $brands = $brandRepository->findAll();
        $types = $typeRepository->findAll();

        return $this->render('main/cart.html.twig', [
            'types' => $types,
            'categories' => $categories,
            'brands' => $brands,
            'cart' => $cart,
        ]);
    }

     /**
     * Ajout d'un article au panier
     * 
     * id<\d+> équivaut à requirements={"id"="\d+"}
     * 
     * @Route("/cart/add/{id<\d+>}", name="app_cart_add")
     */
    public function add(int $id)
    {
        $this->cartService->add($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * supprimer une quantité d'un produit
     * 
     * id<\d+> équivaut à requirements={"id"="\d+"}
     * 
     * @Route("/cart/delete/{id<\d+>}", name="app_cart_delete")
     */
    public function deleteFrom(int $id)
    {
        $this->cartService->deleteFromCart($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * supprimer un produit, quelque soit le nombre de quantité
     * 
     * id<\d+> équivaut à requirements={"id"="\d+"}
     * 
     * @Route("/cart/deleteAll/{id<\d+>}", name="app_cart_deleteAll")
     */
    public function deleteAllCart(int $id)
    {
        $this->cartService->deleteAllCart($id);
        return $this->redirectToRoute('app_cart');
    }

    /**
     * Vider le panier
     * 
     * @Route("/cart/deleteAll", name="app_cart_deleteCart")
     */
    public function deleteCart(Request $request, int $id, Product $product)
    {
        $this->cartService->deleteCart($id);
        return $this->redirectToRoute('app_main_home');
    }


}
