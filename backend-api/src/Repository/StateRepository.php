<?php

namespace App\Repository;

use App\Entity\State;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method State|null find($id, $lockMode = null, $lockVersion = null)
 * @method State|null findOneBy(array $criteria, array $orderBy = null)
 * @method State[]    findAll()
 * @method State[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, State::class);
    }

    public function fetchAllOrderedByName(): array
    {
        return $this->createQueryBuilder('s')
                    ->orderBy('s.uf')
                    ->getQuery()
                    ->execute([], AbstractQuery::HYDRATE_ARRAY);
    }
}
