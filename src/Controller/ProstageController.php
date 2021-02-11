<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

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
     * @Route("/stages", name="prostage_stages")
     */
    public function stages(): Response
    {
        // Récupérer le repository de l'entité Stage
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        // Récupérer les stages enregistrés en BD
        $stages = $repositoryStage->findAllJoinEntrepriseAndFormation();

        // Envoyer les stages récupérés à la vue chargée de les afficher
        return $this->render('prostage/stages.html.twig',['stages'=>$stages]);
    }

    /**
     * @Route("/stage/{id}", name="prostage_stage")
     */
    public function stage($id): Response
    {
        // Récupérer le repository de l'entité Stage
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        // Récupérer les stages enregistrés en BD
        $stage = $repositoryStage->find($id);

        // Envoyer le stage récupéré à la vue chargée de l'afficher
        return $this->render('prostage/stage.html.twig',['stage' => $stage]);
    }

    /**
     * @Route("/entreprises", name="prostage_entreprises")
     */
    public function entreprises(): Response
    {
        // Récupérer le repository de l'entité Entreprise
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        // Récupérer les entreprises enregistrées en BD
        $entreprises = $repositoryEntreprise->findAll();

          // Envoyer les entreprises récupérées à la vue chargée de les afficher
        return $this->render('prostage/entreprises.html.twig',['entreprises'=>$entreprises]);
    }

    /**
     * @Route("/entreprise/{nomEntreprise}", name="prostage_entreprise")
     */
    public function entreprise($nomEntreprise): Response
    {
        // Récupérer le repository de l'entité Entreprise
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        // Récupérer l'entreprise enregistrée en BD
        $entreprise = $repositoryEntreprise->findOneByNom($nomEntreprise);

        // Récupérer le repository de l'entité Stage
        $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

        // Récupérer les stages enregistrés en BD
        $stages = $repositoryStage->findByNomEntreprise($nomEntreprise);

        // Envoyer l'entreprise récupérée à la vue chargée de l'afficher
        return $this->render('prostage/entreprise.html.twig',['entreprise' => $entreprise,'stages' => $stages]);
    }

    /**
     * @Route("/formations", name="prostage_formations")
     */
    public function formations(): Response
    {
        // Récupérer le repository de l'entité Formation
        $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

        // Récupérer les formations enregistrées en BD
        $formations = $repositoryFormation->findAll();

        // Envoyer les formations récupérées à la vue chargée de les afficher
        return $this->render('prostage/formations.html.twig',['formations' => $formations]);
    }

    /**
     * @Route("/formation/{sigleFormation}", name="prostage_formation")
     */
    public function formation($sigleFormation): Response
    {
      // Récupérer le repository de l'entité Formation
      $repositoryFormation = $this->getDoctrine()->getRepository(Formation::class);

      // Récupérer la formation enregistrée en BD
      $formation = $repositoryFormation->findOneBySigle($sigleFormation);

      // Récupérer le repository de l'entité Stage
      $repositoryStage = $this->getDoctrine()->getRepository(Stage::class);

      // Récupérer les stages enregistrés en BD
      $stages = $repositoryStage->findBySigleFormation($sigleFormation);

      // Envoyer la formation récupérée à la vue chargée de l'afficher
      return $this->render('prostage/formation.html.twig',['formation' => $formation,'stages' => $stages]);
    }


}
