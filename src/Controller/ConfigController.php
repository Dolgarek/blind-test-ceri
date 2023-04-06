<?php

namespace App\Controller;

use App\Form\ConfigPartieType;
use App\Repository\MusiqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{
    public function __construct(private readonly MusiqueRepository $musiqueRepository, private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/config', name: 'config', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $configPartie = [];
        $form = $this->createForm(ConfigPartieType::class, $configPartie);

        $form->handleRequest($request);
        //dd($request, $form->getData(), $configPartie, $form);

        if ($form->isSubmitted() && $form->isValid()) {
            $configPartie = $form->getData();
            $musiquesFromTheme = $this->musiqueRepository->findBy(['themes' => $configPartie['themes']]);
            if ($configPartie['tags'] != null) {
                $tags = explode(",", $form->get('tags')->getData());
                $configPartie['tags'] = $tags;
            } else {
                $configPartie['tags'] = [];
            }
            if (sizeof($configPartie['tags']) > 0) {
                $musiquesFromTags = $this->musiqueRepository->findBy(['tags' => $configPartie['tags']]);
                $musiquesList = array_unique(array_merge($musiquesFromTheme, $musiquesFromTags));
            }
            return $this->redirectToRoute('app_jeu_index', ['options' => $form->getData()]);
        }

        return $this->render('config/index.html.twig', [
            'controller_name' => 'ConfigController',
            'form' => $form,
        ]);
}

}