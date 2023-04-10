<?php

namespace App\Controller;

use App\Repository\CurrentAnswerRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EndingJeuController extends AbstractController
{
    public function __construct(
        private readonly UtilisateurRepository $utilisateurRepository
    ) {}
    #[Route('/finJeu', name: 'app_finjeu')]
    public function index(Request $request, CurrentAnswerRepository $currentAnswerRepository): Response
    {
        $ssid = $request->query->get('ssid');
        $music = $currentAnswerRepository->findBy(['ssid' => $ssid]);
        $musiques = [];
        foreach ($music as $m) {
            $newMusique = [];
            $newMusique['answer'] = $m->getAnswer();
            $newMusique['id'] = $m->getCurrentId();
            $newMusique['answerCorrect'] = $m->isAnswerCorrect();
            $newMusique['titre'] = $m->getTitre();
            $musiques[] = $newMusique;
        }
        //dd($request, $music, $deserializedMusic);
        return $this->render('pageEndingJeu/index.html.twig', [
            'controller_name' => 'EndingJeuController',
            'user' => $this->utilisateurRepository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]),
            'musiques' => $musiques
        ]);
    }
}