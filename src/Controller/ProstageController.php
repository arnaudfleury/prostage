<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;

class ProstageController extends AbstractController
{
    /**
     * @Route("/", name="prostage_accueil")
     */
    public function index(): Response
    {
        return $this->render('prostage/index.html.twig');
    }

    /**
     * @Route("/entreprises", name="prostage_entreprises")
     */
    public function entreprises(): Response
    {
        return $this->render('prostage/entreprises.html.twig');
    }

    /**
     * @Route("/formations", name="prostage_formations")
     */
    public function formations(): Response
    {
        return $this->render('prostage/formations.html.twig');
    }

    /**
     * @Route("/stage/{id}", name="prostage_stage")
     */
    public function stage($id): Response
    {
        // Récupérer le repository de l'entité Ressource
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        // Récupérer les ressources enregistrées en BD
        $stage = $repositoryStage->find($id);

        // Envoyer les ressources récupérées à la vue chargée de les afficher
        return $this->render('prostage/stage.html.twig',['stage' => $stage]);
    }

    /**
     * @Route("/stages", name="prostage_stages")
     */
    public function stages(): Response
    {
        // Récupérer le repository de l'entité Ressource
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        // Récupérer les ressources enregistrées en BD
        $stages = $repositoryStage->findAll();

        // Envoyer les ressources récupérées à la vue chargée de les afficher
        return $this->render('prostage/stages.html.twig',['stages'=>$stages]);
    }
}
