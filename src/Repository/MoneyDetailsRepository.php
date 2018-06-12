<?php

namespace App\Repository;

use App\Entity\MoneyDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MoneyDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoneyDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoneyDetails[]    findAll()
 * @method MoneyDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoneyDetailsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MoneyDetails::class);
    }

//    /**
//     * @return MoneyDetails[] Returns an array of MoneyDetails objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MoneyDetails
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
