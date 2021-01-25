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
        //on crée une instance d'annonce
        $annonce =new Annonces;
        //on créer un forma de type annonce et on le donne notre annonce
        $form = $this->createForm(AnnoncesType::class, $annonce);

        //on donne à notre form la réqueste vient s'il existe
        $form->handleRequest($request);

        //on teste si notre forme est dêje sbmit est ses champs sont tous valide
        if ($form->isSubmitted() && $form->isValid())
        {
            //si oui on va stocker les informations de nouveau annonce à la base de données
            
            //on mettra l'utilisateur actuel comme la créateur de l'annonce 
            
            $annonce->setUser($this->getUser());
            //on stocke le nome de manager de la service de registrer de doctrine 
            $em = $this->getDoctrine()->getManager();

            //on stocke l'instance d'annonce dans la BD en utilisant le Manager
            $em->persist($annonce);
            
            //On Synchronne l'etat de l'objet avec la base de données
            $em->flush();

            return $this->redirectToRoute("user_home");
        }

        

        return $this->render('user/annonce/ajoute.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
