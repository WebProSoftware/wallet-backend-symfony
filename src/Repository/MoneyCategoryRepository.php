<?php

namespace App\Repository;

use App\Entity\MoneyCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MoneyCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method MoneyCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method MoneyCategory[]    findAll()
 * @method MoneyCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoneyCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MoneyCategory::class);
    }

//    /**
//     * @return MoneyCategory[] Returns an array of MoneyCategory objects
//     */

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


    /*
    public function findOneBySomeField($value): ?MoneyCategory
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
