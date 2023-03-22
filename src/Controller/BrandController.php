<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BrandController extends AbstractController
{
     /**
     * Page d'une brand'
     * 
     * @Route("/brands/{id}", name="app_main_brand", methods={"GET"})
     */
    public function brandAction(int $id,BrandRepository $brandRepository, ProductRepository $productRepository, CategoryRepository $categoryRepository, TypeRepository $typeRepository)
    {
        // on récupère la liste des films les plus récents (dump() pour vérifier)
        $brand = $brandRepository->find($id);

        $productList = $productRepository->findBy(['brand' => $brand]);

        $categories = $categoryRepository->findAll();
        $brands = $brandRepository->findAll();
        $types = $typeRepository->findAll();

        return $this->render('main/brand.html.twig', [
            'brand' => $brand,
            'productList' => $productList,
            'types' => $types,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
