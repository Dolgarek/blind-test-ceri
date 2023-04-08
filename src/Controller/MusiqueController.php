<?php

namespace App\Controller;

use App\Entity\Musique;
use App\Entity\MusiqueImporte;
use App\Entity\MusiqueInfo;
use App\Form\MusiqueType;
use App\Repository\MusiqueImporteRepository;
use App\Repository\MusiqueInfoRepository;
use App\Repository\MusiqueRepository;
use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/musique')]
class MusiqueController extends AbstractController
{
    #[Route('/', name: 'app_musique_index', methods: ['GET'])]
    public function index(MusiqueRepository $musiqueRepository): Response
    {
        return $this->render('musique/index.html.twig', [
            'musiques' => $musiqueRepository->findAll(),
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/new', name: 'app_musique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MusiqueRepository $musiqueRepository, MusiqueImporteRepository $musiqueImporteRepository, SluggerInterface $slugger): Response
    {
        $musique = new Musique();
        $form = $this->createForm(MusiqueType::class, $musique);
        if ($this->getUser()->getRoles()[0] != "ROLE_ADMIN") {
            $form->remove('isGlobal');
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$form->get('musique')->getData()) {
                $this->addFlash('admin_warning', 'Vous devez ajouter une musique');
                return $this->render('musique/new.html.twig', [
                    'musique' => $musique,
                    'form' => $form,
                ]);
            }
            $extraData = $this->processExtraData($form);
            $extraData['musique'] = $form->get('musique')->getData();

            if ($extraData['tags'] != null) {
                $tags = explode(",", $form->get('tags')->getData());
                $extraData['tags'] = $tags;
            } else {
                $extraData['tags'] = [];
            }
            $originalFilename = pathinfo($extraData['musique']->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$extraData['musique']->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $extraData['musique']->move(
                    $this->getParameter('musiques_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $musiqueInfo = new MusiqueInfo();
            $musiqueInfo->setMusique($musique);
            $musiqueInfo->setGroupe($extraData['groupe']);
            $musiqueInfo->setTitre($extraData['titre']);
            $musiqueInfo->setAlbum($extraData['album']);
            $musiqueInfo->setArtiste($extraData['artiste']);
            $musiqueInfo->setDateDeSortie($extraData['date']);
//            $musiqueInfo->setThemes($extraData['themes']);
            foreach ($extraData['themes'] as $theme){
                $musiqueInfo->addTheme($theme);
            }
            $musiqueInfo->setTags($extraData['tags']);
            $musiqueInfo->setTimestamp($extraData['timestamp']);
            if ($this->getUser()->getRoles()[0] != "ROLE_ADMIN") {
                $musique->setIsGlobal(false);
                $musiqueImporte = new MusiqueImporte();
                $musiqueImporte->setMusiqueInfo($musiqueInfo);
                $musiqueImporte->setUtilisateur($this->getUser());
                $musiqueImporte->setDateImportation(new \DateTime());
                $musiqueInfo->setMusiqueImporte($musiqueImporte);
            }
            $musique->setMusiqueInfo($musiqueInfo);
            $musique->setMusiqueFilename($newFilename);
            $musiqueRepository->save($musique, true);

            return $this->redirectToRoute('app_musique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('musique/new.html.twig', [
            'musique' => $musique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_musique_show', methods: ['GET'])]
    public function show(Musique $musique): Response
    {
        return $this->render('musique/show.html.twig', [
            'musique' => $musique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_musique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Musique $musique, MusiqueRepository $musiqueRepository, MusiqueInfoRepository $musiqueInfoRepository, ThemeRepository $themeRepository): Response
    {//        $formData = ['titre' => $musique->getMusiqueInfo()->getTitre()];

//        $form = $this->createForm(MusiqueType::class, $musique);

//        $musique = $musiqueRepository->find($id);
        //dump($musique, $musique->getMusiqueInfo()->getTitre());

        $form = $this->createForm(MusiqueType::class, $musique);

        $form->remove('musique');
        if ($this->getUser()->getRoles()[0] != "ROLE_ADMIN") {
            $form->remove('isGlobal');
        }

//        $form->setData($data);
        $tagsStr = "";
        foreach ($musique->getMusiqueInfo()->getTags() as $tag) {
            $tagsStr .= $tag . ",";
        }
        $tagsStr = substr($tagsStr, 0, -1);


        $form->get('groupe')->setData($musique->getMusiqueInfo()->getGroupe());
        $form->get('titre')->setData($musique->getMusiqueInfo()->getTitre());
        $form->get('album')->setData($musique->getMusiqueInfo()->getAlbum());
        $form->get('artiste')->setData($musique->getMusiqueInfo()->getArtiste());
        $form->get('date')->setData($musique->getMusiqueInfo()->getDateDeSortie());
        $form->get('themes')->setData($musique->getMusiqueInfo()->getThemes());
        $form->get('tags')->setData($tagsStr);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $extraData = $this->processExtraData($form);
            $musique->setIsGlobal($extraData['isGlobal']);
            $musiqueInfo = $musique->getMusiqueInfo();
            $musiqueInfo->setGroupe($extraData['groupe']);
            $musiqueInfo->setTitre($extraData['titre']);
            $musiqueInfo->setAlbum($extraData['album']);
            $musiqueInfo->setArtiste($extraData['artiste']);
            $musiqueInfo->setDateDeSortie($extraData['date']);
            foreach ($themeRepository->findAll() as $theme){
                $theme->removeMusiqueInfo($musiqueInfo);
                $themeRepository->save($theme, true);
            }
            foreach ($extraData['themes'] as $theme){
                $themeRepository->findOneBy(['nom' => $theme->getNom()])->addMusiqueInfo($musiqueInfo);
                $themeRepository->save($themeRepository->findOneBy(['nom' => $theme->getNom()]), true);
            }
            $musiqueInfo->setTags($extraData['tags']);
            $musiqueInfo->setTimestamp($extraData['timestamp']);
            if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN") {
                $musique->setIsGlobal($form->get('isGlobal')->getData());
            }

            $musiqueInfoRepository->save($musiqueInfo, true);
            $musiqueRepository->save($musique, true);

            return $this->redirectToRoute('app_musique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('musique/edit.html.twig', [
            'musique' => $musique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_musique_delete', methods: ['POST'])]
    public function delete(Request $request, Musique $musique, MusiqueRepository $musiqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$musique->getId(), $request->request->get('_token'))) {
            $musiqueRepository->remove($musique, true);
        }

        return $this->redirectToRoute('app_musique_index', [], Response::HTTP_SEE_OTHER);
    }

    public function processExtraData($form): array
    {
        $extraData = [];
        if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN"){
            if ($form->get('isGlobal')->getData() != null) {
                $extraData['isGlobal'] = $form->get('isGlobal')->getData();
            }
        }
        else {
            $extraData['isGlobal'] = false;
        }
        $extraData['groupe'] = $form->get('groupe')->getData();
        $extraData['titre'] = $form->get('titre')->getData();
        $extraData['album'] = $form->get('album')->getData();
        $extraData['artiste'] = $form->get('artiste')->getData();
        $extraData['date'] = $form->get('date')->getData();
        $extraData['themes'] = $form->get('themes')->getData();
        $extraData['tags'] = $form->get('tags')->getData();
        $extraData['timestamp'] = $form->get('timestamp')->getData();
        if ($extraData['tags'] != null) {
            $tags = explode(",", $form->get('tags')->getData());
            $extraData['tags'] = $tags;
        } else {
            $extraData['tags'] = [];
        }
        return $extraData;
    }
}
