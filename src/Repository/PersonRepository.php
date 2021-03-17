<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function searchPerson($data){

        $qb =
           $this->createQueryBuilder('p')
            ->where('p.state = :selectedActive OR p.state = :selectedBanned OR p.state = :selectedDeleted OR p.f_name LIKE :fname OR p.l_name LIKE :lname OR p.login LIKE :login')
            ->setParameter('selectedActive', $data['state'][0])
            ->setParameter('selectedBanned', $data['state'][1])
            ->setParameter('selectedDeleted', $data['state'][2])
            ->setParameter('fname', '%'.$data['search'].'%')
            ->setParameter('lname', '%'.$data['search'].'%')
            ->setParameter('login', '%'.$data['search'].'%')

            ->getQuery()->getResult();
        return $qb;
    }
}
