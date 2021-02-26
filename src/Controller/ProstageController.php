<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Form\EntrepriseType;
use App\Form\StageType;

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

    /**
     * @Route("/entreprises/ajouter", name="prostage_ajoutEntreprise")
     */
    public function ajouterEntreprise(Request $request, EntityManagerInterface $manager)
    {
        //Création d'une entreprise vierge qui sera remplie par le formulaire
        $entreprise = new Entreprise();

        // Création du formulaire permettant de saisir l'entreprise
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        $formulaireEntreprise->handleRequest($request);

         if ($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
         {
            $manager = $this->getDoctrine()->getManager();

            // Enregistrer l'entreprise en base de données
            $manager->persist($entreprise);
            $manager->flush();

            // Rediriger l'utilisateur vers la page des entreprises
            return $this->redirectToRoute('prostage_entreprises');
         }

        // Afficher la page présentant le formulaire d'ajout d'un entreprise
        return $this->render('prostage/ajoutModifEntreprise.html.twig',['vueFormulaire' => $formulaireEntreprise->createView(), 'action'=>"ajouter"]);
    }


    /**
     * @Route("/entreprises/modifier/{id}", name="prostage_modifEntreprise")
     */
    public function modifierEntreprise(Request $request, EntityManagerInterface $manager, Entreprise $entreprise)
    {
        // Création du formulaire permettant de modifier un entreprise
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        $formulaireEntreprise->handleRequest($request);

         if ($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
         {
            $manager = $this->getDoctrine()->getManager();
            // Enregistrer le entreprise en base de données
            $manager->persist($entreprise);
            $manager->flush();

            // Rediriger l'utilisateur vers la page des entreprises
            return $this->redirectToRoute('prostage_entreprises');
         }

        // Afficher la page présentant le formulaire de modification d'une entreprise
        return $this->render('prostage/ajoutModifEntreprise.html.twig',['vueFormulaire' => $formulaireEntreprise->createView(), 'action'=>"modifier"]);
    }

    /**
     * @Route("/stages/ajouter", name="prostage_ajoutStage")
     */
    public function ajouterStage(Request $request, EntityManagerInterface $manager)
    {
        //Création d'un stage vierge qui sera rempli par le formulaire
        $stage = new Stage();

        // Création du formulaire permettant de saisir le stage
        $formulaireStage = $this->createForm(StageType::class, $stage);

        $formulaireStage->handleRequest($request);

         if ($formulaireStage->isSubmitted() )
         {
            $manager = $this->getDoctrine()->getManager();
            // Mémoriser la date d'ajout du stage
            $stage->setDate(new \dateTime());
            // Stage non archivé
            $stage->setArchive(false);
            // Enregistrer le stage en base de donnée
            $manager->persist($stage);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('prostage_accueil');
         }

        // Afficher la page présentant le formulaire d'ajout d'un stage
        return $this->render('prostage/ajoutModifStage.html.twig',['vueFormulaire' => $formulaireStage->createView(), 'action'=>"ajouter"]);
    }


    /**
     * @Route("/stages/modifier/{id}", name="prostage_modifStage")
     */
    public function modifierStage(Request $request, EntityManagerInterface $manager, Stage $stage)
    {
        // Création du formulaire permettant de modifier un stage
        $formulaireStage = $this->createForm(StageType::class, $stage);

        $formulaireStage->handleRequest($request);

         if ($formulaireStage->isSubmitted() )
         {
            $manager = $this->getDoctrine()->getManager();
            // Enregistrer le stage en base de donnéelse
            $manager->persist($stage);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('prostage_accueil');
         }

        // Afficher la page présentant le formulaire d'ajout d'un stage
        return $this->render('prostage/ajoutModifStage.html.twig',['vueFormulaire' => $formulaireStage->createView(), 'action'=>"modifier"]);
    }

}
