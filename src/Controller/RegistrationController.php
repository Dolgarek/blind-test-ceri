<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() != null) {
            return $this->redirectToRoute('app_accueil');
        }

        $user = new Utilisateur();
        //$form = $this->createForm(RegistrationFormType::class, $user);
        //$form->handleRequest($request);
        $res = $request->request->all();
        //dump($res,strlen($res['username']) == 0 && strlen($res['nom']) == 0 && strlen($res['prenom']) == 0 &&  strlen($res['password']) == 0 && !in_array("terms", $res));
        //dd($res, array_key_exists("terms", $res));
        if (!array_key_exists("terms", $res)) {
            return $this->render('registration/register.html.twig', [
                'error' => false
            ]);
        }
        $isComplete = strlen($res['username']) > 0 && strlen($res['nom']) > 0 && strlen($res['prenom']) > 0 &&  strlen($res['password']) > 5 && $res['terms'] == "true";
        //dump($isComplete, strlen($res['username']) > 0);
        if ($isComplete) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $res["password"]
                )
            );

            $date = new \DateTimeImmutable();

            $user->setUsername($res["username"]);
            $user->setRoles(['ROLE_USER']);
            $user->setNom($res["nom"]);
            $user->setPrenom($res["prenom"]);
            $user->setCreatedAt($date);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_accueil');
        }
        //dd($res, $test);
        /*if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $date = new \DateTimeImmutable();

            $user->setUsername($form->get("username")->getData());
            $user->setRoles(['ROLE_USER']);
            $user->setNom("default_nom");
            $user->setPrenom("default_prenom");
            $user->setCreatedAt($date);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_accueil');
        }*/

        /*return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'error' => !$isComplete
        ]);*/

        return $this->render('registration/register.html.twig', [
            'error' => !$isComplete
        ]);
    }
}
