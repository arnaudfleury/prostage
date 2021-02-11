<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stage[]    findAll()
 * @method Stage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    /**
    * @return Stage[] Returns an array of Stage objects
    */

    public function findAllJoinEntrepriseAndFormation()
    {
        return $this->createQueryBuilder('s')
            ->addSelect('e, f')
            ->join('s.entreprise','e')
            ->join('s.formations','f')
            ->orderBy('s.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByNomEntreprise($nomEntreprise)
    {
        return $this->createQueryBuilder('s')
            ->join('s.entreprise','e')
            ->andWhere('e.nom = :nomEntreprise')
            ->setParameter('nomEntreprise', $nomEntreprise)
            ->orderBy('s.date', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findBySigleFormation($sigleFormation)
    {
       // Récupérer le gestionnaire d'entité
       $entityManager = $this->getEntityManager();

       // Construction de la requête
       $requete = $entityManager->createQuery(
         'SELECT s, f
          FROM App\Entity\Stage s
          JOIN App\Entity\Formation f
          WHERE s.id = f.id
          AND f.sigle = :sigleFormation'
       );

       // Définition de la valeur du paramètre injecté dans la requête
       $requete->setParameter('sigleFormation',$sigleFormation);

       // Exécuter la requête et retourner les résultats
       return $requete->execute();
    }


    /*
    public function findOneBySomeField($value): ?Stage
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
