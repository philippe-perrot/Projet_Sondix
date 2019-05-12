<?php

namespace App\Repository;

use App\Entity\Choix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;

/**
 * @method Choix|null find($id, $lockMode = null, $lockVersion = null)
 * @method Choix|null findOneBy(array $criteria, array $orderBy = null)
 * @method Choix[]    findAll()
 * @method Choix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChoixRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Choix::class);
    }

    public function createChoice (int $id_resultat, int $id_question, int $id_reponse)
    {
        $config = new Configuration();
        $connectionParams = array(
            'url' => 'mysql://root:@127.0.0.1:3306/bdd_sondix'
        );
        $sql = "INSERT INTO choix (id, id_resultat, id_question, id_reponse) VALUES (NULL, :id_resultat, :id_question, :id_reponse)";
        $stmt = DriverManager::getConnection($connectionParams, $config)->prepare($sql);
        $stmt->execute(array(':id_resultat' => $id_resultat, ':id_question' => $id_question, ':id_reponse' => $id_reponse));
    }

    // /**
    //  * @return Choix[] Returns an array of Choix objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Choix
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
