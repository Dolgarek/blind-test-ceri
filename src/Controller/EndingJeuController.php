<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EndingJeuController extends AbstractController
{
    public function __construct(
        private readonly UtilisateurRepository $utilisateurRepository
    ) {}
    #[Route('/finjeu', name: 'app_finjeu')]
    public function index(): Response
    {
        return $this->render('pageEndingJeu/index.html.twig', [
            'controller_name' => 'EndingJeuController',
            'user' => $this->utilisateurRepository->findOneBy(['username' => $this->getUser()->getUserIdentifier()])
        ]);
    }
}