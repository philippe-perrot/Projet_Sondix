<?php

namespace App\Repository;

use App\Entity\Resultat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;

/**
 * @method Resultat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resultat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resultat[]    findAll()
 * @method Resultat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResultatRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Resultat::class);
    }

    public function createResult (int $id_personne, int $id_qcm)
    {
        $config = new Configuration();
        $connectionParams = array(
            'url' => 'mysql://root:@127.0.0.1:3306/bdd_sondix'
        );
        $sql = "INSERT INTO resultat (id, id_personne, id_qcm, score) VALUES (NULL, :id_personne, :id_qcm, 0)";
        $stmt = DriverManager::getConnection($connectionParams, $config)->prepare($sql);
        $stmt->execute(array(':id_personne' => $id_personne, ':id_qcm' => $id_qcm));
    }

    public function setScore (int $id_resultat, int $score)
    {
        $config = new Configuration();
        $connectionParams = array(
            'url' => 'mysql://root:@127.0.0.1:3306/bdd_sondix'
        );
        $sql = "UPDATE resultat SET score = :score WHERE id = :id";
        $stmt = DriverManager::getConnection($connectionParams, $config)->prepare($sql);
        $stmt->execute(array(':score' => $score, ':id' => $id_resultat));
    }

    public function getIdResult (int $qcm)
    {
        return $this->createQueryBuilder('resultat')
            ->andWhere('resultat.id_qcm = :id')
            ->setParameter('id', $qcm)
            ->getQuery()
            ->getResult();
    }


    // /**
    //  * @return Resultat[] Returns an array of Resultat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Resultat
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
