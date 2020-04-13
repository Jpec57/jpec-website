<?php

namespace App\Repository;

use App\Entity\UserCardInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserCardInfo|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCardInfo|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCardInfo[]    findAll()
 * @method UserCardInfo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCardInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCardInfo::class);
    }

    public function findByIdsForUser(array $ids, int $userId): iterable
    {
      return $this->createQueryBuilder('u')
        ->leftJoin('u.card', 'c')
        ->where('u.user = :userId')
        ->andWhere('c.id IN (:ids)')
        ->setParameters([
          'ids' => $ids,
          'userId' => $userId
        ])
        ->orderBy('c.id')
        ->getQuery()
        ->getResult();
    }
}
