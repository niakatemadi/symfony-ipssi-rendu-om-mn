<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('', name: 'app_home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findLastArticles(3);

        
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
