<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile')]
    public function getProfile(): Response
    {

        $user = $this->getUser();
       // dd($user);
        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
