<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Form\UserPasswordFormType;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


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

    #[Route('profile/{id}/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function editProfile(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

           // return $this->redirectToRoute('app_user_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('content/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('profile/{id}/password/edit', name: 'app_profile_password_edit', methods: ['GET', 'POST'])]
    public function editPassword(Request $request, User $user, UserRepository $userRepository,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(UserPasswordFormType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $userRepository->save($user, true);

           // return $this->redirectToRoute('app_user_test_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('content/user/edit.password.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

   
}
