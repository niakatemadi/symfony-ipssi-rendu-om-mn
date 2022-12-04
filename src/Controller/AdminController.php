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
use App\Form\UserType;
use App\Form\CategoryType;
use App\Form\AdminArticleFormType;
use App\Form\AdminFilteredUserType;
use App\Form\AdminFilteredProductsType;


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

        //Articles
    #[Route('/articles', name: 'app_admin_articles', methods: ['GET','POST'])]
    public function getFilteredArticles(ArticleRepository $articleRepository, Request $request): Response
    {

        $sortArticleForm = $this->createForm(AdminArticleFormType::class);
        $sortArticleForm->handleRequest($request);

        $articles = $articleRepository->findAscOrDescArticles('DESC');

        if ($sortArticleForm->isSubmitted() && $sortArticleForm->isValid()) {
           
            $ascOrDesc = $sortArticleForm->get('content')->getData();

            $articles = $articleRepository->findAscOrDescArticles($ascOrDesc);

        }

        return $this->renderForm('content/article/show.articles.html.twig', [
            'articles' => $articles,
            'form' => $sortArticleForm,
        ]);
    }

    #[Route('/articles/create', name: 'app_article_create', methods: ['GET', 'POST'])]
    public function createArticle(Request $request, ArticleRepository $articleRepository): Response
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
    public function showArticle(Article $article): Response
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

    //Catégory
    // récupère toutes les catégories par ordre DESC or ASC
    #[Route('/category', name: 'app_admin_category')]
    public function getAllCategories(CategoryRepository $categoryRepository, Request $request): Response
    {

        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        $categories = $categoryRepository->findAscOrDescCategory('ASC');

        if ($form->isSubmitted() && $form->isValid()) {
            $ascOrDesc = $form->get('name')->getData();

            $categories = $categoryRepository->findAscOrDescCategory($ascOrDesc);
        }


        return $this->renderForm('content/category/index.html.twig', [
            'categories' => $categories,
            'form' => $form
        ]);
    }

    //User
    // permet de recevoir la liste des utilisateurs en fonction de leurs statut "client" ou "vendeur"
    #[Route('/user', name: 'app_admin_user')]
    public function getUsersByStatut(UserRepository $userRepository, Request $request): Response
    {
        $form = $this->createForm(AdminFilteredUserType::class);
        $form->handleRequest($request);

        $users = $userRepository->findUsersByStatut('vendeur');

        if ($form->isSubmitted() && $form->isValid()) {
            $userStatut = $form->get('statut')->getData();

            $users = $userRepository->findUsersByStatut($userStatut);
        }

        return $this->renderForm('admin/displayUsersPage/index.html.twig', [
            'users' => $users,
            'form' => $form
        ]);
    }

    //Product
    #[Route('/products', name: 'app_admin_products')]
    public function showFilteredProducts(ProductRepository $productRepository, Request $request): Response
    {

        $form = $this->createForm(AdminFilteredProductsType::class);
        $form->handleRequest($request);

        $products = $productRepository ->findAll();

        if ($form->isSubmitted() && $form->isValid()) {

            $ascOrDesc = $form->get('description')->getData();
            $categoryName = $form->get('category')->getData();
            $SellerName = $form->get('seller')->getData();

            $products = $productRepository ->productFilterByCategorySellerAscDesc($categoryName,$SellerName,$ascOrDesc);

        }

        return $this->renderForm('admin/products/index.html.twig', [
            'products' => $products,
            'form' => $form,
        ]);
    }
}
