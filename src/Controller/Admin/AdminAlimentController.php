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
        
        $form = $this->createForm(AlimentType::class, $aliment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aliment);
            $entityManager->flush();
            return $this-> redirectToRoute('admin_aliment');
        }
        return $this->render('admin/admin_aliment/modifEtAjout.html.twig',[
            "aliment" => $aliment,
            "form" =>  $form->createView(),
            "isModification" => $aliment->getId() !== null
        ]);
    }
      /**
     * @Route("/admin/aliment/{id}", name="admin_aliment_supression", methods="delete")
     */
    public function supression(Aliments $aliment, Request $request, EntityManagerInterface $entityManager): Response
    {
    if($this->isCsrfTokenValid("SUP". $aliment->getId(),$request->get('_token'))){
        $entityManager->remove($aliment);
        $entityManager->flush();
        return $this-> redirectToRoute('admin_aliment');
    }
    }
}
