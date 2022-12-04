<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;

class AdminController extends AbstractController
{

    // Permet de récupérer le nombre d'article, category, produits et utilisateur du site
    #[Route('/admin', name: 'app_admin')]
    public function getWebsiteStatistics(CategoryRepository $categoryRepository,ArticleRepository $articleRepository,ProductRepository $productRepository,UserRepository $userRepository): Response
    {

        $articlesCount = count($articleRepository->findAll());
        $productsCount = count($productRepository->findAll());
        $categoryCount = count($categoryRepository->findAll());
        $usersCount = count($userRepository->findAll());
        return $this->render('admin/index.html.twig', [
            'articlesCount' => $articlesCount,
            'productsCount' => $productsCount,
            'categoryCount' => $categoryCount,
            'usersCount' => $usersCount,
        ]);
    }
}
