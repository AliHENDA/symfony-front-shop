<?php

namespace App\Controller;

use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\TypeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController {

    /**
     * Page d'accueil
     * 
     * @Route("/", name="app_main_home", methods={"GET"})
     */
    public function home(CategoryRepository $categoryRepository, TypeRepository $typeRepository, \App\Repository\BrandRepository $brandRepository)
    {
        // on récupère la liste des films les plus récents (dump() pour vérifier)
        $categories = $categoryRepository->findAll();
        $brands = $brandRepository->findAll();
        $types = $typeRepository->findAll();
        // ce dump depus un contrôleur ira dnas la WDT
        // si le debug-bundle est installé
       $categoriesHomePage = $categoryRepository->categoriesHomePage();
       // dd($categoriesHomePage);


        // on rend une vue HTML avec Twig
        // @todo #2 les envoyer à la vue et la dynamiser
        // @see https://twig.symfony.com/doc/3.x/tags/for.html
        return $this->render('main/home.html.twig', [
            'categories' => $categories,
            'brands' => $brands,
            'types' => $types,
            'categoriesHomePage' => $categoriesHomePage
        ]);
    }

}