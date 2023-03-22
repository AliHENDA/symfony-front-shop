<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController {

    /**
     * Page d'une categorie'
     * 
     * @Route("/categories/{id}", name="app_main_category", methods={"GET"})
     */
    public function categoryAction(int $id, CategoryRepository $categoryRepository, ProductRepository $productRepository, TypeRepository $typeRepository, BrandRepository $brandRepository)
    {
        // on récupère la liste des films les plus récents (dump() pour vérifier)
        $category = $categoryRepository->find($id);
  
        $productList = $productRepository->findBy(['category' => $category]);
   
        $categories = $categoryRepository->findAll();
        $brands = $brandRepository->findAll();
        $types = $typeRepository->findAll();

        return $this->render('main/category.html.twig', [
            'category' => $category,
            'productList' => $productList,
            'types' => $types,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

}

