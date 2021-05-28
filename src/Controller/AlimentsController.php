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
            'isCalorie' => false
        ]);
    }
    /**
     * @Route("/aliment/{calorie}", name="alimentsParCalorie")
     */
    public function alimentsMoinsCaloriques(AlimentsRepository $repository, $calorie): Response
    {
        $aliments = $repository->getAlimentParNbCalories($calorie);
        return $this->render('aliments/aliments.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => true
        ]);
    }
}
