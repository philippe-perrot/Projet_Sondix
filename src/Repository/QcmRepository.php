<?php

namespace App\Repository;

use App\Entity\Qcm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Qcm|null find($id, $lockMode = null, $lockVersion = null)
 * @method Qcm|null findOneBy(array $criteria, array $orderBy = null)
 * @method Qcm[]    findAll()
 * @method Qcm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QcmRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Qcm::class);
    }
    
    //Retourne les 4 derniers QCM mis en ligne
    public function findLatest(): array
    {
        return $this->findVisibleQcm()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }
    
    //Retourne les QCM validés et mis en ligne
    private function findVisibleQcm(): QueryBuilder
    {
        return $this->createQueryBuilder('qcm')
            ->where('qcm.etat_qcm = 0');
    }


    // /**
    //  * @return Qcm[] Returns an array of Qcm objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Qcm
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
