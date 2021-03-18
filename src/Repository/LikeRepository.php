<?php

namespace App\Repository;

use App\Entity\Like;
use App\Entity\Person;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Like|null find($id, $lockMode = null, $lockVersion = null)
 * @method Like|null findOneBy(array $criteria, array $orderBy = null)
 * @method Like[]    findAll()
 * @method Like[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Like::class);
    }

//pobranie wszystkich polubień oraz pokaznanie zamiast ID loginu oraz produktu
    public function getAllData(){
        return $this->createQueryBuilder('d')
            ->select('d.id, pe.login, pr.name')
                ->join(Person::class,'pe','WITH','pe.id = d.person_id')
                ->join(Product::class,'pr','WITH','pr.id = d.product_id')
                ->getQuery()->getResult();

    }

//    funkcja szukająca polubień po loginie i nazwie produktu
    public function searchLike($data){
        return $this->createQueryBuilder('d')
            ->select('d.id, pe.login, pr.name')
            ->join(Person::class,'pe','WITH','pe.id = d.person_id')
            ->join(Product::class,'pr','WITH','pr.id = d.product_id')
            ->where('pe.login LIKE :login OR pr.name LIKE :name')
            ->setParameter('login', '%'.$data['search'].'%')
            ->setParameter('name', '%'.$data['search'].'%')
            ->getQuery()->getResult();
    }
}
