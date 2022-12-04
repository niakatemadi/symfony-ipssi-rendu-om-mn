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

#[Route('/profile')]
class UserController extends AbstractController
{

    // Permet d'affiche les infos de l'utilisateur connecté sur la page profile

    #[Route('/{id}', name: 'app_profile')]
    public function getProfile(ProductRepository $productRepository): Response
    {

        $user = $this->getUser();
        $products = $productRepository->getMyProducts($user);
        
        return $this->render('user/index.html.twig', [
            'user' => $user,
            'products' => $products
        ]);
    }

    // Permet de modifier les infos de profile de l'utilisateur connecté
    #[Route('/{id}/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function editProfile(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

        }

        return $this->renderForm('content/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    //Permet de modifier le mot de passe de l'utilisateur connecté
        
    #[Route('/{id}/password/edit', name: 'app_profile_password_edit', methods: ['GET', 'POST'])]
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

        }

        return $this->renderForm('content/user/edit.password.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}
