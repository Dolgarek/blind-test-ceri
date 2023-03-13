<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/utilisateur')]
class UtilisateurController extends AbstractController
{
    #[Route('/', name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UtilisateurRepository $utilisateurRepository, SluggerInterface $slugger): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        $avatarFile = $form->get('avatar')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setRoles(['ROLE_USER']);

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ...
                }

                $utilisateur->setAvatarFileName($newFilename);
            }

            $utilisateurRepository->save($utilisateur, true);
            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/api/get/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/api/me', name: 'app_utilisateur_api_me', methods: ['GET', 'POST'])]
    public function me(UtilisateurRepository $utilisateurRepository): Response
    {
        $user = $utilisateurRepository->findOneBy(['username' => $this->getUser()->getUserIdentifier()]);
        //dd($user);
        $jsonArr = [
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'username' => $user->getUsername(),
            'username' => $user->getUsername(),
        ];
        $response = new Response(json_encode($jsonArr));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route('/api/me/edit/{id}', name: 'app_utilisateur_api_me_edit', methods: ['POST'])]
    public function meEdit(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository, SluggerInterface $slugger, UserPasswordHasherInterface $passwordHasher): Response
    {
        $requestArr = $request->toArray();

        $user = $utilisateurRepository->findOneBy(["username" => $requestArr["username"]]);
        $user->setNom($requestArr["lastName"]);
        $user->setPrenom($requestArr["firstName"]);

        $newPass = $requestArr["password"];
        if ((strlen($newPass) > 5)) {
            $user->setPassword($passwordHasher->hashPassword($user, $newPass));
        }

        if(strlen($newPass) > 5 || strlen($newPass) == 0) {
            $utilisateurRepository->save($user, true);

            return new Response(json_encode([
                "username" => $requestArr["username"],
                "firstName" => $requestArr["firstName"],
                "lastName" => $requestArr["lastName"]
            ]), 200);
        }
        return new Response(json_encode([
            "error" => "password seems incorrect",
        ]), 400);
    }

    #[Route('/edit/{id}', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateurRepository->save($utilisateur, true);
            $avatarFile = $form->get('avatar')->getData();

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ...
                }

                $utilisateur->setAvatarFileName($newFilename);
            }

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/api/edit/{id}', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function apiEdit(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateurRepository->save($utilisateur, true);
            $avatarFile = $form->get('avatar')->getData();

            if ($avatarFile) {
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $avatarFile->guessExtension();

                try {
                    $avatarFile->move(
                        $this->getParameter('avatars_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ...
                }

                $utilisateur->setAvatarFileName($newFilename);
            }

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $utilisateur->getId(), $request->request->get('_token'))) {
            $utilisateurRepository->remove($utilisateur, true);
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
