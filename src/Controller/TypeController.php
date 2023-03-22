<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeController extends AbstractController {

    /**
     * Page d'une type'
     * 
     * @Route("/types/{id}", name="app_main_type", methods={"GET"})
     */
    public function typeAction(int $id, TypeRepository $typeRepository, ProductRepository $productRepository, BrandRepository $brandRepository, CategoryRepository $categoryRepository)
    {
        $type = $typeRepository->find($id);
        
        $productList = $productRepository->findBy(['type' => $type]);

        $categories = $categoryRepository->findAll();
        $brands = $brandRepository->findAll();
        $types = $typeRepository->findAll();

        return $this->render('main/type.html.twig', [
            'type' => $type,
            'productList' => $productList,
            'types' => $types,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}