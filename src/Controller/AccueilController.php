<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    public function __construct(
        private readonly UtilisateurRepository $utilisateurRepository
    ) {}
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'user' => $this->utilisateurRepository->findOneBy(['username' => $this->getUser()->getUserIdentifier()])
        ]);
    }
}
