<?php

namespace App\Repository;

use App\Entity\Logistics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Logistics>
 *
 * @method Logistics|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logistics|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logistics[]    findAll()
 * @method Logistics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogisticsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logistics::class);
    }

    public function add(Logistics $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
