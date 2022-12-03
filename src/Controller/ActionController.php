<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ArticleType;
use App\Form\ProductCreateType;
use App\Entity\Article;
use App\Entity\Product;
use DateTimeImmutable;


class ActionController extends AbstractController
{

    //Admin
    #[Route('/admin', name: 'app_admin')]
    public function createArticle(Request $request, ArticleRepository $articleRepository): Response
    {

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        $user = $this->getUser();
        
        $article->setAuthor($user);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setAuthor($user);
            $article->setCreatedAt(new DateTimeImmutable('now'));
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('content/article/create.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);

    }

    //Product

    #[Route('/profile/product/create', name: 'app_create_product', methods: ['GET', 'POST'])]
    public function createProduct(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductCreateType::class, $product);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $product->setCreatedAt(new DateTimeImmutable('now'));
            $product->setSeller($user);

            $productRepository->save($product, true);

            return $this->redirectToRoute('app_test_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('test_product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
}
