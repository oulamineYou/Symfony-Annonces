<?php

namespace App\Controller;

use App\Entity\Annonces;
use App\Form\AnnoncesType;
use App\Form\UserProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user_home")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
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

    /**
     * @Route("/user/Profile/modefier", name="modifier_profile")
     */
    public function ModifierProfile(Request $request): Response
    {
        //on met l'utilisateur actuel dans l'instance user
        $user = $this->getUser();
        //on créer un forma de type UserProfile et on le donne l'utilisateur
        $form = $this->createForm(UserProfileType::class, $user);

        //on donne à notre form la réqueste vient s'il existe
        $form->handleRequest($request);

        //on teste si notre forme est dêje sbmit est ses champs sont tous valide
        if ($form->isSubmitted() && $form->isValid())
        {
            //si oui on va stocker les informations de nouveau annonce à la base de données

            //on stocke le nome de manager de la service de registrer de doctrine 
            $em = $this->getDoctrine()->getManager();

            //on stocke l'instance d'annonce dans la BD en utilisant le Manager
            $em->persist($user);
            
            //On Synchronne l'etat de l'objet avec la base de données
            $em->flush();

            return $this->redirectToRoute("user_home");
        }        

        return $this->render('user/profile/modifier.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/Profile/modefier_password", name="modifier_password")
     */
    public function ModifierPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        
        if( $request->isMethod('POST') )
        {
            //on crééer ontre manager
            $em = $this->getDoctrine()->getManager();

            //on met l'utilisateur actuel dans l'instance user
            $user = $this->getUser();

            if($request->request->get('pass') == $request->request->get('pass1'))
            {
                $user->setPassword($passwordEncoder->encodePassword($user,$request->request->get('pass')));
                $em->persist($user);
                $em->flush();
                $this->addFlash('success','le mot de passe est bien changé');
                return $this->redirectToRoute("user_home");
            }else{
                $this->addFlash('error', "les deux mots de passe ne sont pas identique");
            }
        }

        return $this->render('user/profile/modifier_password.html.twig');
    }

}
