<?php

namespace App\Controller\Admin;

use App\Entity\Aliments;
use App\Form\AlimentType;
use App\Repository\AlimentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAlimentController extends AbstractController
{
    /**
     * @Route("/admin/aliment", name="admin_aliment")
     */
    public function index(AlimentsRepository $repository): Response
    {
        $aliments = $repository->findAll();
        return $this->render('admin/admin_aliment/adminAliment.html.twig', [
            "aliments" => $aliments
        ]);
    }
      /**
     * @Route("/admin/aliment/creation", name="admin_aliment_creation")
     * @Route("/admin/aliment/{id}", name="admin_aliment_modification", methods="GET|POST")
     */
    public function ajoutEtModification(Aliments $aliment = null, Request $request, EntityManagerInterface $entityManager): Response
    {
        if(!$aliment) {
            $aliment = new Aliments();
        }
        
        //CREATE
        $form = $this->createForm(AlimentType::class, $aliment);
        $form->handleRequest($request);
        //on vérifie que le formulaire est soumis et ok
        if($form->isSubmitted() && $form->isValid()) {
            //on envoi les nouvelles données dans la bdd
            $entityManager->persist($aliment);
            $entityManager->flush();
            //On vérifie que l'on est pas dans le cas d'une création
            $modif = $aliment->getId() !== null;
            //message de validation
            $this->addFlash("success", ($modif) ? "La modification a bien été effectuée" : "L'ajout a bien été effectué");
            //redirection à la fin de la création/modification
            return $this-> redirectToRoute('admin_aliment');
        }
        
        //UPDATE
        return $this->render('admin/admin_aliment/modifEtAjout.html.twig',[
            //On vérifie que l'on est pas dans le cas d'une création (id diff. de 0)
            "isModification" => $aliment->getId() !== null,
            //on va chercher les données
            "aliment" => $aliment,
            //on affiche le formulaire avec les données à modifier
            "form" =>  $form->createView()
        ]);
    }

    // DELETE
        /**
        * @Route("/admin/aliment/{id}", name="admin_aliment_supression", methods="delete")
        */
    public function supression(Aliments $aliment, Request $request, EntityManagerInterface $entityManager): Response
    {
    if($this->isCsrfTokenValid("SUP". $aliment->getId(),$request->get('_token'))){
        $entityManager->remove($aliment);
        $entityManager->flush();
        $this->addFlash("success", "La suppression a bien été effectuée");
        return $this-> redirectToRoute('admin_aliment');
    }
    }
}
