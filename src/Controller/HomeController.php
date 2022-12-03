<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Repository\ProductRepository;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('', name: 'app_home')]
    public function getLastArticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findLastArticles(3);

        
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('products', name: 'app_home_products')]
    public function getProducts(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        
        return $this->render('home/products.html.twig', [
            'products' => $products,
        ]);
    }
}
