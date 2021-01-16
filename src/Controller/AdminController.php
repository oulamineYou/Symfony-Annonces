<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_home")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/categorie/ajoute", name="ajoute_categorie")
     */
    public function ajouterCategorie(Request $request): Response
    {
        $categorie = new Categorie;
        $form = $this->createForm(CategorieType::class,$categorie ,['attr' => ['class' => 'm-3']]);

        //on prendra ce qui vient par le Request Http
        $form->handleRequest($request);

        //on test est ce que les informations de forms sont sumis et valide
        if( $form->isSubmitted() && $form->isValid() ){
            //on stocke le nome de manager de la service de registrer de doctrine 
            $em = $this->getDoctrine()->getManager();

            //on stocke l'instance categorie dans la BD en utilisant le Manager
            $em->persist($categorie);

            //On Synchronne l'etat de l'objet avec la base de données
            $em->flush();

            return $this->redirectToRoute("admin_home");
        }


        return $this->render('admin/categorie/ajoute.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
