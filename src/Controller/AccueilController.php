<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    public function __construct(
        private readonly UtilisateurRepository $utilisateurRepository
    ) {}
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'user' => $this->utilisateurRepository->findOneBy(['username' => $this->getUser()->getUserIdentifier()])
        ]);
    }
    /*/**
  * @Rest\View()
  * @Rest\Get("/verifierConsentement")
  * @SWG\Response(
  *    response="200"
  *    description = "Return bool",
  *    @SWG\Schema(type="bool", description="true or false"
  *)
  * @SWG\Parameter(
  *    name="Authorization",
  *    type="string",
  *    in="header",
  *    required=true,
  *    description="Authentication token Bearer",
  *)
  ** @SWG\Response(
  *    response="401"
  *    description = "Unauthorized",
  *    example= {
  *      "Nothing found :"
  *      {
  *          "code": 401,
  *          "message": "Wrong Credentials"
  *      }
  *    }
  *)
  */

    /*public function verificationConsentementUtilisateur(): Response
    {
        $user = $this->getUserConnected();
        $rpgd = $user->getRgpd();

        $dernierRGPD = $this->rgpdRepository->findOneBy(['name'=>'RGPD', 'visible' => 1], ['createdAt' => DESC]);

        $accepter = false;
        if(!empty($dernierRGPD->toArray()) {
            $dernierRGPD=$rpgd->last();
            if($dernierRGPD !== null && $dernierRGPD->getAgreedAt() != null) {
                $accepter = $dernierRGPD->getConsentement() === $dernierRGPD;
            }
        }

        $result = [
            'accepter' => $acceptter,
            'dernierRGPD' => new SimpleRGPDModel($dernierRGPD)
        ];

        return new JsonResponse($result);
    }*/
    /**
     * @Rest\View()
     * @Rest\Get("/validerConsentement")
     * @SWG\Response(
     *    response="201"
     *    description = "return the validation",
     *    @SWG\Schema(type="RGPD", type="Object", ref=@Model(type=SimpleRGPDUserModel::class)
     *)
     * @SWG\Parameter(
     *    name="Authorization",
     *    type="string",
     *    in="header",
     *    required=true,
     *    description="Authentication token Bearer",
     *)
     ** @SWG\Response(
     *    response="401"
     *    description = "Unauthorized",
     *    example= {
     *      "Nothing found :"
     *      {
     *          "code": 401,
     *          "message": "Wrong Credentials"
     *      }
     *    }
     *)
     *return SimpleRGPDUserModel
     */

    /*public function validationConsentement(): SimpleRGPDUserModel
    {
        $user = $this->getUserConnected();
        $dernierRGPD = $this->rgpdRepository->findOneBy(['name'=>'RGPD', 'visible' => 1], ['createdAt' => DESC]);
        $userRGPD = $user->getRgpd();

        $userRGPD = new ConsentementUser();
        $userRGPD->setUser($user);
        $userRGPD->setRGPD($dernierRGPD)
  $userRGPD->setAgreedAt(new Datetime());

  $this->userRGPDRepository(save($userRGPD));
  return new SimpleRGPDModel($dernierRGPD);
}*/
}
