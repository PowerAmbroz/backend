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
        $active = '';
        $banned = '';
        $deleted = '';

        if($data['stateActive'] === true){
            $active = 1;
        }
        if($data['stateBanned'] === true){
            $banned = 2;
        }
        if($data['stateDeleted'] === true){
            $deleted = 3;
        }

        if($data['search'] === null && ($data['stateActive'] === true || $data['stateBanned'] === true || $data['stateDeleted'] === true)){
            return
                $this->createQueryBuilder('p')
                    ->where('p.state = :stateActive OR p.state = :selectedBanned OR p.state = :selectedDeleted')
                    ->setParameter('stateActive', $active)
                    ->setParameter('selectedBanned', $banned)
                    ->setParameter('selectedDeleted', $deleted)
                    ->getQuery()->getResult();
        }

        if($data['search'] != null && ($data['stateActive'] === true || $data['stateBanned'] === true || $data['stateDeleted'] === true)){
            return
                $this->createQueryBuilder('p')
                    ->where('p.f_name LIKE :fname OR p.l_name LIKE :lname OR p.login LIKE :login')
                    ->setParameter('fname', '%'.$data['search'].'%')
                    ->setParameter('lname', '%'.$data['search'].'%')
                    ->setParameter('login', '%'.$data['search'].'%')
                    ->andWhere('p.state = :stateActive OR p.state = :selectedBanned OR p.state = :selectedDeleted')
                    ->setParameter('stateActive', $active)
                    ->setParameter('selectedBanned', $banned)
                    ->setParameter('selectedDeleted', $deleted)
                    ->getQuery()->getResult();
        }

        if($data['search'] != null && ($data['stateActive'] != true || $data['stateBanned'] != true || $data['stateDeleted'] != true)){
            return
                $this->createQueryBuilder('p')
                    ->where('p.f_name LIKE :fname OR p.l_name LIKE :lname OR p.login LIKE :login')
                    ->setParameter('fname', '%'.$data['search'].'%')
                    ->setParameter('lname', '%'.$data['search'].'%')
                    ->setParameter('login', '%'.$data['search'].'%')
                    ->getQuery()->getResult();
        }
}

}
