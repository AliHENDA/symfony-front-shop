<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use App\Repository\BrandRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController {

    /**
     * Page d'une product'
     * 
     * @Route("/product/{id}", name="app_main_product", methods={"GET"})
     */
    public function productAction(int $id, ProductRepository $productRepository, BrandRepository $brandRepository, TypeRepository $typeRepository, CategoryRepository $categoryRepository)
    {

        $product = $productRepository->find($id);
        $categories = $categoryRepository->findAll();
        $brands = $brandRepository->findAll();
        $types = $typeRepository->findAll();

        return $this->render('main/product.html.twig', [
            'product' => $product,
            'types' => $types,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}