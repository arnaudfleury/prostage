<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProstageController extends AbstractController
{
    /**
     * @Route("/", name="prostage_accueil")
     */
    public function index(): Response
    {
        return $this->render('prostage/index.html.twig', [
            'controller_name' => 'Bienvenue sur la page d\'accueil de Prostages',
        ]);
    }

    /**
     * @Route("/entreprises", name="prostage_entreprises")
     */
    public function entreprises(): Response
    {
        return $this->render('prostage/index.html.twig', [
            'controller_name' => 'Cette page affichera la liste des entreprises proposant un stage',
        ]);
    }

    /**
     * @Route("/formations", name="prostage_formations")
     */
    public function formations(): Response
    {
        return $this->render('prostage/index.html.twig', [
            'controller_name' => 'Cette page affichera la liste des formations de l\'IUT',
        ]);
    }

    /**
     * @Route("/stages/{id}", name="prostage_stages")
     */
    public function stages($id): Response
    {
        return $this->render('prostage/index.html.twig', [
            'controller_name' => 'Cette page affichera le descriptif du stage ayant pour identifiant : '.$id,
        ]);
    }
}
