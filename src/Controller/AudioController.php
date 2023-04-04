<?php

namespace App\Controller;

use App\Repository\MusiqueRepository;
use getID3;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Musique;

class AudioController extends AbstractController
{
    #[Route('/api/playSong/{id}', name: 'play_song', methods: ['GET'])]
    public function playSong(int $id, MusiqueRepository $musiqueRepository)
    {
        $musique = $musiqueRepository->find($id);

        if (!$musique) {
            throw $this->createNotFoundException(
                'Aucune musique trouvée pour cet ID : '.$id
            );
        }

        $musiqueFilename = $musique->getMusiqueFilename();
        $filePath = $this->getParameter('musiques_directory').'/'.$musiqueFilename;

        // Utiliser getID3 pour obtenir des informations sur le fichier
        $getID3 = new getID3();
        $audioInfo = $getID3->analyze($filePath);

        //TODO: Add timestamp support
        $bitrate = $audioInfo['bitrate'] / 8; // Convertir le débit binaire en bytes par seconde
        $startByte = 15 * $bitrate; // Calculer le nombre de bytes à ignorer en fonction du débit binaire
        //dd($audioInfo);


        $response = new BinaryFileResponse($filePath);
        $response->headers->set('Content-Type', 'audio/mpeg');
        $response->headers->set('Content-Disposition', 'inline; filename="'.$musiqueFilename.'"');
        $response->headers->set('Accept-Ranges', 'bytes');

        return $response;
    }

    #[Route('/playSong', name: 'play_start', methods: ['GET'])]
    public function playStart(): Response
    {
        return $this->render('audio/playSong.html.twig');
    }
}