<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\State;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

    public function fetchCitiesByUf(State $uf): array
    {
        return $this->createQueryBuilder('c')
                    ->orderBy('c.name')
                    ->where('c.state = :uf')
                    ->getQuery()
                    ->execute(['uf'=>$uf], AbstractQuery::HYDRATE_ARRAY);
    }
}
