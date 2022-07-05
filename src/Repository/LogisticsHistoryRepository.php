<?php

namespace App\Repository;

use App\Entity\LogisticsHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogisticsHistory>
 *
 * @method LogisticsHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogisticsHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogisticsHistory[]    findAll()
 * @method LogisticsHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogisticsHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogisticsHistory::class);
    }

    public function add(LogisticsHistory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
