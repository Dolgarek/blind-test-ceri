<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageLoginController extends AbstractController
{
    #[Route('/login', name: 'app_Login')]
    public function index(): Response
    {
        return $this->render('pageLogin/index.html.twig', [
            'controller_name' => 'PageLoginController',
        ]);
    }
}