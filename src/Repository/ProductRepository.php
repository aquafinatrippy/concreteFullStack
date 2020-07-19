<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
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

    public function getProductsData()
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->getQuery()
            ->getArrayResult();
    }


    public function findOnTruck($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.onTruck = :val')
            ->setParameter('val', $value)
            ->setMaxResults(2)
            ->getQuery()
            ->getArrayResult();
    }
    public function orderWeight(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.weight', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->execute();
    }

    public function findLessThanWeight($weight): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.weight < :weight')
            ->setParameter('weight', $weight)
            ->andWhere('p.onTruck is NULL')
            ->orderBy('p.weight', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->execute();
    }
}
