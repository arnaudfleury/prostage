<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\Stage;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création d'un générateur de données Faker
        $faker = \Faker\Factory::create('fr_FR');

        $formationInfo = new Formation();
        $formationInfo->setSigle("DUT INFO");
        $formationInfo->setIntitule("Diplôme Universitaire Technologique Informatique");
        $manager->persist($formationInfo);

        $formationLPM = new Formation();
        $formationLPM->setSigle("LP Multimédia");
        $formationLPM->setIntitule("Licence Professionnelle Multimédia");
        $manager->persist($formationLPM);

        $formationDUTIC = new Formation();
        $formationDUTIC->setSigle("DU TIC");
        $formationDUTIC->setIntitule("Diplôme Universitaire en Technologies de l’Information et de la Communication");
        $manager->persist($formationDUTIC);

        $tabFormations = array($formationInfo,$formationLPM,$formationDUTIC);

        $tabEntreprise = array();
        for($i=0; $i < 5; $i++){
          $entreprise = new Entreprise();
          $nomEntreprise = $faker->company();
          $entreprise->setNom($nomEntreprise);
          $entreprise->setAdresse($faker->address());
          $entreprise->setSiteWeb("https://www.".$nomEntreprise.".fr");
          $tabEntreprise[$i] = $entreprise;
          $manager->persist($entreprise);
        }

        foreach ($tabEntreprise as $entreprise) {
          $nbStagesEntreprise = $faker->numberBetween($min = 1, $max = 3);
          for($nbStages=0; $nbStages < $nbStagesEntreprise; $nbStages++){
            $stage = new Stage();
            $stage->setTitre($faker->realText($maxNbChars = $faker->numberBetween($min=50,$max=100), $indexSize = 2));
            $stage->setDate($faker->dateTimeBetween($startDate = '-2 months', $endDate = 'now', $timezone = 'Europe/Paris'));
            $stage->setActivite($faker->word());
            $stage->setLieu($entreprise->getAdresse());
            $stage->setDescription($faker->realText($maxNbChars = $faker->numberBetween($min=300,$max=3000), $indexSize = 2));
            $stage->setArchive(false);
            $stage->setMail($faker->email());
            $numFormation = $faker->numberBetween($min = 0, $max = 2);
            $stage->addFormation($tabFormations[$numFormation]);
            $tabFormations[$numFormation]->addStage($stage);
            $stage->setEntreprise($entreprise);
            $entreprise->addStage($stage);
            $manager->persist($stage);
          }
        }
        $manager->flush();
    }
}
