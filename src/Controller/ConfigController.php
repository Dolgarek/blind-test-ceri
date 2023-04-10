<?php

namespace App\Controller;

use App\Entity\CurrentAnswer;
use App\Form\ConfigPartieType;
use App\Repository\CurrentAnswerRepository;
use App\Repository\MusiqueInfoRepository;
use App\Repository\MusiqueRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConfigController extends AbstractController
{
    public function __construct(
        private readonly MusiqueRepository $musiqueRepository,
        private readonly MusiqueInfoRepository $musiqueInfoRepository,
        private readonly ThemeRepository $themeRepository,
        private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route('/config', name: 'app_config', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        $configPartie = [];
        $form = $this->createForm(ConfigPartieType::class, $configPartie);

        $form->handleRequest($request);
        //dd($request, $form->getData(), $configPartie, $form);

        if ($form->isSubmitted() && $form->isValid()) {
            $configPartie = $form->getData();
            $musiqueNotMerged = [];
            $conn = $this->entityManager->getConnection();
            foreach ($form->get('themes')->getData() as $theme) {

                $sql = 'SELECT * FROM theme_musique_info tmi WHERE tmi.theme_id = :theme';
                $stmt = $conn->prepare($sql);
                $resultSet = $stmt->executeQuery(['theme' => $theme->getId()]);
                foreach ($resultSet->fetchAllAssociative() as $row) {
                    $musiqueInfo = $this->musiqueInfoRepository->find($row['musique_info_id']);
                    if ($musiqueInfo->getMusique()->isIsGlobal() || ($musiqueInfo->getMusiqueImporte() && $musiqueInfo->getMusiqueImporte()->getUtilisateur()->getUserIdentifier() == $this->getUser()->getUserIdentifier()) || $this->getUser()->getRoles()[0] == 'ROLE_ADMIN') {
                        $musiqueNotMerged[] = $musiqueInfo;
                    }
                }
                //dd($this->musiqueInfoRepository->findAll()[0]->getThemes(), $musiqueNotMerged);
            }
            $musiqueNotMergedTags = [];
            if ($form->get('tags')->getData() != null){
                $tags = explode(",", $form->get('tags')->getData());
                foreach ($tags as $tag) {
                    $qb = $this->entityManager->createQueryBuilder();
                    $qb->select('musiqueInfo')
                        ->from("App:MusiqueInfo", 'musiqueInfo')
                        ->where('musiqueInfo.tags LIKE :tag')
                        ->setParameter('tag', '%' . $tag . '%' );
                    foreach ($qb->getQuery()->getResult() as $musiqueInfo) {
                        if ($musiqueInfo->getMusique()->isIsGlobal() || ($musiqueInfo->getMusiqueImporte() && $musiqueInfo->getMusiqueImporte()->getUtilisateur()->getUserIdentifier() == $this->getUser()->getUserIdentifier()) || $this->getUser()->getRoles()[0] == 'ROLE_ADMIN') {
                            $musiqueNotMergedTags[] = $musiqueInfo;
                        }
                    }
                }
            }
            $musiquesList = array_unique(array_merge($musiqueNotMerged, $musiqueNotMergedTags));

            //dd($configPartie, $musiqueNotMerged, $musiquesList, $musiqueNotMergedTags);
            if (sizeof($musiquesList) < $form->get('nbMusic')->getData()) {
                $this->addFlash('admin_warning', 'Il n\'y a pas assez de musiques pour cette configuration (Taille de la liste: ' . sizeof($musiquesList) . ', Nombre de musiques demandées: ' . $form->get('nbMusic')->getData() . ')');
                return $this->redirectToRoute('app_config', []);
            }
            if (sizeof($musiquesList) > $form->get('nbMusic')->getData()) {
                $loopSize = sizeof($musiquesList) - $form->get('nbMusic')->getData();
                for ($i = 0; $i < $loopSize; $i++) {
                    unset($musiquesList[array_rand($musiquesList)]);
                }
            }
            dump($musiquesList);
            return $this->forward('App\Controller\JeuController::index',
                [
                    'option' => $musiquesList,
                    'config' => $configPartie,
                    ]);
        }

        return $this->render('config/index.html.twig', [
            'controller_name' => 'ConfigController',
            'form' => $form,
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/config/answer', name: 'app_config_answer', methods: ['POST'])]
    public function postAnswer(Request $request, CurrentAnswerRepository $currentAnswerRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $exist = $currentAnswerRepository->findOneBy(['currentId' => $data['index'], 'ssid' => $data['ssid']]);
        //dump($exist, $exist2);
        if ($exist) {
            $exist->setAnswer($data['answer']);
            $this->entityManager->persist($exist);
        } else {
            $currentAnswer = new CurrentAnswer();
            $currentAnswer->setCurrentId($data['index']);
            $currentAnswer->setSsid($data['ssid']);
            $currentAnswer->setAnswer($data['answer']);
            $currentAnswer->setTitre($data['titre']);
            $currentAnswer->setAnswerCorrect($data['titre'] == $data['answer']);
            $this->entityManager->persist($currentAnswer);
        }
        $this->entityManager->flush();
        dump($request, $request->request->all(), $request->request->get('answer'), $data);
        return $this->json(['success' => true]);
    }

}