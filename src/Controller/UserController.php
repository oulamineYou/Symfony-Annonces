<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user_home")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

     /**
     * @Route("/user/annonce/ajoute", name="ajoute_annonce")
     */
    public function ajouteAnnonce(Request $request): Response
    {

        $annonce =new Annonces;

        $form = $this->createForm(AnnoncesType::class, $annonce);

        return $this->render('user/annonce/ajoute.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
