<?php
namespace App\Controller;

use App\Repository\AlimentsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlimentsController extends AbstractController
{
    /**
     * @Route("/", name="aliments")
     */
    public function index(AlimentsRepository $repository): Response
    {
        $aliments = $repository->findAll();
        return $this->render('aliments/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' => false
        ]);
    }
    /**
     * @Route("/aliment/calorie/{calorie}", name="alimentsParCalorie")
     */
    public function alimentsMoinsCaloriques(AlimentsRepository $repository, $calorie): Response
    {
        $aliments = $repository->getAlimentParPropriete('calories','<',$calorie);
        return $this->render('aliments/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => true,
            'isGlucide' => false
        ]);
    }
    /**
     * @Route("/aliment/glucide/{glucide}", name="alimentsParGlucide")
     */
    public function alimentsMoinsGlucides(AlimentsRepository $repository, $glucide): Response
    {
        $aliments = $repository->getAlimentParPropriete('glucide','<',$glucide);
        return $this->render('aliments/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' => true
        ]);
    }
}
