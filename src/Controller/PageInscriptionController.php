<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageInscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_Inscription')]
    public function index(): Response
    {
        return $this->render('pageInscription/index.html.twig', [
            'controller_name' => 'PageInscriptionController',
        ]);
    }
}