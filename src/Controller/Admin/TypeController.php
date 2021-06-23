<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TypeController extends AbstractController
{
    /**
     * @Route("/admin/type", name="admin_types")
     */
    public function index(TypeRepository $repo)
    {
        $types = $repo->findAll();
        return $this->render('admin/type/adminType.html.twig', [
            "types" => $types
        ]);
    }

    // Fonction de modification
    /**
     * @Route("/admin/type/create", name="ajoutType")
     * @Route("/admin/type/{id}", name="modifType", methods="POST|GET")
     */
    public function ajoutEtModif(Type $type = null, Request $request, ObjectManager $om) //On utilise le paramater converter pour retrouver les informations dans la bdd à l'aide de l'id. Puis le request pour récupérer les infos envoyées depuis le formulaire. Puis l'objectManager 
    {
        if(!$type) {
            $type = new Type();
        }

        $form = $this->createForm(TypeType::class, $type); //on ajoute une 2ème info en indiquant le lien vers l'objet "Type"

        $form->handleRequest($request); // on récupère la requête
        if($form->isSubmitted() && $form->isValid()) { // et on vérifie que le formulaire à été soumis et qu'il est valide. Si ok on peut apporter les modif en bdd via l'object manager.
            $om->persist($type);
            $om->flush();
            $this->addFlash('success', "L'action a été réalisé");
            return $this->redirectToRoute('admin_types');   
        }

        return $this->render('admin/type/modifEtAjout.html.twig', [
            "type" => $type,
            "form" => $form->createView()
        ]);
    }

    // Fonction de suppression
     /**
     * @Route("/admin/type/{id}", name="supType", methods="delete")
     */
    public function supression(Type $type, ObjectManager $om, Request $request)
    {
        if($this->isCsrfTokenValid('SUP'.$type->getId(), $request->get('_token'))){
            $om->remove($type);
            $om->flush();
            $this->addFlash('success', "L'action a été réalisée");
            return $this->redirectToRoute("admin_types");
        }
    }
}
