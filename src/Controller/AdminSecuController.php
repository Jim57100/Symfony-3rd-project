<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminSecuController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, ObjectManager $om, UserPasswordEncoderInterface $encoder) //On récupère les données du formulaire via l'injection de dépendance
    {
        $utilisateur = new Utilisateur;
        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $passwordCrypt = $encoder->encodePassword($utilisateur, $utilisateur->getPassword()); //On encode le mdp
            $utilisateur->setPassword($passwordCrypt); 
            $om->persist($utilisateur);
            $om->flush();
            return $this->redirectToRoute("aliments");
        }

        return $this->render('admin_secu/inscription.html.twig',[
            "form" => $form->createView()
        ]);
    }
    /**
     * @Route("/login", name="connexion")
     */
    public function login(AuthenticationUtils $util){
        return $this->render("admin_secu/login.html.twig", [
            "lastUserName" => $util->getLastUsername(),
            "error" => $util->getLastAuthenticationError()
        ]);
    }
    /**
     * @Route("/logout", name="deconnexion")
     */
    public function logout(){
       
    }

}
