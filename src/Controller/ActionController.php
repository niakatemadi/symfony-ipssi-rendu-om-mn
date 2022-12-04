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
use App\Form\ProductEditType;
use App\Entity\Article;
use App\Entity\Product;
use DateTimeImmutable;


class ActionController extends AbstractController
{


    //Product
    // get All products
    #[Route('/profile/products', name: 'app_products_get')]
    public function showAllProducts(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('content/product/index.html.twig', [
            'products' => $products,
        ]);
    }

    //Create product
    #[Route('/profile/product/create', name: 'app_product_create', methods: ['GET', 'POST'])]
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

          //  return $this->redirectToRoute('app_test_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('content/product/create.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    //Edit product
    #[Route('profile/product/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function editProduct(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductEditType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $product->setUpdatedAt(new DateTimeImmutable('now'));
            $productRepository->save($product, true);

           // return $this->redirectToRoute('app_test_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('content/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    //Delete product
    #[Route('profile/product/delete/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }
        $userId = $this->getUser()->getId();
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }
}
