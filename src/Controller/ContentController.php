<?php

namespace App\Controller;


use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductFilterType;

#[Route('/')]
class ContentController extends AbstractController
{

// Pages sans connexions
// affiche les 3 articles les plus récents
    #[Route('', name: 'app_home')]
    public function getLastArticles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findLastArticles(3);

        
        return $this->render('content/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    // affiche la liste des produits basée sur des filtres
    #[Route('products', name: 'app_home_products')]
    public function getFilteredProducts(Request $request, ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        $productForm = $this->createForm(ProductFilterType::class);
        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            
            $price = $productForm->get('price')->getData();
            $category = $productForm->get('category')->getData();
            $seller = $productForm->get('seller')->getData();
            $quantity = 1;

            $products = $productRepository->productFilterByCategoryPriceSeller($category,$seller,$price);

        }

        return $this->renderForm('content/products.html.twig', [
            'products' => $products,
            'productForm'=>$productForm
        ]);
    }

    //Affiche tout les détails sur un produit
    #[Route('products/{id}', name: 'app_home_product')]
    public function getProductDetails(Product $product, ProductRepository $productRepository): Response
    {
        
        return $this->render('content/product.html.twig', [
            'product' => $product,
        ]);
    }
}
