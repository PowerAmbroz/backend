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
//        Ustawienie lokalnych zmiennych
        $active = '';
        $banned = '';
        $deleted = '';

//        Sprawdzenie czy checkboxy są zaznaczone - mają status true i dopisanie wartości do odpowiednich zmiennych
        if($data['stateActive'] === true){
            $active = 1;
        }
        if($data['stateBanned'] === true){
            $banned = 2;
        }
        if($data['stateDeleted'] === true){
            $deleted = 3;
        }

//        Kryteria wyszukowania, jeśli nic nie zostało wpisane w search, ale zaznaczono jakiś checkbox
        if($data['search'] === null && ($data['stateActive'] === true || $data['stateBanned'] === true || $data['stateDeleted'] === true)){
            return
                $this->createQueryBuilder('p')
                    ->where('p.state = :stateActive OR p.state = :selectedBanned OR p.state = :selectedDeleted')
                    ->setParameter('stateActive', $active)
                    ->setParameter('selectedBanned', $banned)
                    ->setParameter('selectedDeleted', $deleted)
                    ->getQuery()->getResult();
        }

//        Kryteria wyszukowania, jeśli coś zostało wpisane w search i zaznaczono jakiś checkbox
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

//        Kryteria wyszukowania, jeśli coś zostało wpisane w search i nie zaznaczono jakiś checkbox
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
