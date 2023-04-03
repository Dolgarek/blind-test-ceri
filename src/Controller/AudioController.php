<?php

namespace App\Controller;

use App\Repository\MusiqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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

        $response = new BinaryFileResponse($filePath);
        $response->headers->set('Content-Type', 'audio/mpeg');
        $response->headers->set('Content-Disposition', 'inline; filename="'.$musiqueFilename.'"');
        $response->headers->set('Accept-Ranges', 'bytes');

        return $response;
    }
}