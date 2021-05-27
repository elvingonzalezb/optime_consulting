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

    public function findAllProducts()
    {
        
        return $this->getEntityManager()
            ->createQuery('SELECT prod.id, prod.code, prod.nombre, prod.description, prod.brand, prod.price, prod.createdAt, cat.name 
            FROM App:Product prod
            JOIN prod.category cat
            ');
    }

    public function findOneByName($name): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.nombre = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }     

}
