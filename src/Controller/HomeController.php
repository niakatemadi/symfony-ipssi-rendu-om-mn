<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductFilterType;

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
    public function getProducts(Request $request, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        $productForm = $this->createForm(ProductFilterType::class);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            
            $price = $productForm->get('price')->getData();
            $category = $productForm->get('category')->getData();
            $seller = $productForm->get('seller')->getData();
            

            $products = $productRepository->productFilterByCategoryPriceSeller($category,$seller,$price);

          //  return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home/products.html.twig', [
            'products' => $products,
            'productForm'=>$productForm
        ]);
    }
}
