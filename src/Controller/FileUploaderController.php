<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileUploaderController extends AbstractController
{
    #[Route('/file/uploader', name: 'app_file_uploader')]
    public function index(): Response
    {
        return $this->render('file_uploader/index.html.twig', [
            'controller_name' => 'FileUploaderController',
        ]);
    }
}
