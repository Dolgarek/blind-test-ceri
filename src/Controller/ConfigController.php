<?php

namespace App\Controller;

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
            dump($form->getData(), $configPartie);
        }
        else if ($request->isMethod('POST')) {
            $this->addFlash('admin_error', 'Vous devez ajouter au moins un thème');
        }

        return $this->render('config/index.html.twig', [
            'controller_name' => 'ConfigController',
            'form' => $form,
        ]);
}

}