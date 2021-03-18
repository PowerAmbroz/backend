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
//poszukiwanie produktu po nazwie i info
    public function searchProduct($data){
        return $this->createQueryBuilder('pr')
            ->where('pr.name LIKE :name OR pr.info LIKE :info')
            ->setParameter('name', '%'.$data['search'].'%')
            ->setParameter('info', '%'.$data['search'].'%')
            ->getQuery()->getResult();
    }
}
