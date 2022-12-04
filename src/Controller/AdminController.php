<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Form\ArticleType;

#[Route('/admin')]
class AdminController extends AbstractController
{

    // Permet de récupérer le nombre d'article, category, produits et utilisateur du site
    #[Route('', name: 'app_admin')]
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

    #[Route('/articles', name: 'app_admin_articles', methods: ['GET'])]
    public function getFilteredArticles(ArticleRepository $articleRepository): Response
    {

        $articles = $articleRepository->findAll();

        return $this->render('content/article/show.articles.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/articles/create', name: 'app_article_create', methods: ['GET', 'POST'])]
    public function new(Request $request, ArticleRepository $articleRepository): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_admin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('content/article/create.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/articles/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('content/article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/articles/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function editArticle(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $articleRepository->save($article, true);

            return $this->redirectToRoute('app_admin_articles', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('content/article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/articles/{id}/delete', name: 'app_article_delete', methods: ['POST'])]
    public function deleteArticle(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $articleRepository->remove($article, true);
        }

        return $this->redirectToRoute('app_admin_articles', [], Response::HTTP_SEE_OTHER);
    }

    
}
