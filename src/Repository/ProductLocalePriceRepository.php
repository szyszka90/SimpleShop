<?php

namespace App\Repository;

use App\Entity\ProductLocalePrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductLocalePrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductLocalePrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductLocalePrice[]    findAll()
 * @method ProductLocalePrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductLocalePriceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductLocalePrice::class);
    }

//    /**
//     * @return ProductLocalePrice[] Returns an array of ProductLocalePrice objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductLocalePrice
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
