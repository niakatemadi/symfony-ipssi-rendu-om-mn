<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

class UserController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function getProfile(ProductRepository $productRepository): Response
    {

        $user = $this->getUser();
        $products = $productRepository->getMyProducts($user);
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'products' => $products
        ]);
    }
}
