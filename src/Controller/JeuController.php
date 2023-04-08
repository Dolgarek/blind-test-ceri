<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuController extends AbstractController
{
    public function __construct(

    ){}

    #[Route('/jeu', name: 'app_jeu_index')]
    public function index(array $option, array $config): Response
    {
        $countdownSeconds = 10;
        if (isset($config['difficulte']) && sizeof($option) > 0) {
            switch ($config['difficulte']) {
                case '1':
                    $countdownSeconds = 20;
                    break;
                case '2':
                    $countdownSeconds = 15;
                    break;
                case '3':
                    $countdownSeconds = 10;
                    break;
                default:
                    $countdownSeconds = 15;
                    break;
            }
            foreach ($option as $musiqueInfo) {
                $musique[] = [
                    'id' => $musiqueInfo->getId(),
                    'titre' => $musiqueInfo->getTitre(),
                    'timestamp' => $musiqueInfo->getTimestamp(),
                    'answer' => '',
                    'answerCorrect' => false,
                    ];
            }
            shuffle($musique);
            $MusiqueJson = json_encode($musique);
        } else {
            $this->addFlash('warning', 'Veuillez choisir une difficulté et un thème');
            return $this->redirectToRoute('app_config');
        }
        return $this->render('pageJeu/index.html.twig', [
            'controller_name' => 'JeuController',
            'options' => $option,
            'config' => $config,
            'countdownSeconds' => $countdownSeconds,
            'musique' => $MusiqueJson,
        ]);
    }
}
