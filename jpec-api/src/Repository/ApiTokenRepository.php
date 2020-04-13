<?php

namespace App\Repository;

use App\Entity\ApiToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApiToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiToken[]    findAll()
 * @method ApiToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiTokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiToken::class);
    }

  public function findOldTokens(): iterable{
    return $this->createQueryBuilder('a')
      ->andWhere('a.expiresAt <= :expireDate')
      ->setParameters([
        'expireDate' => new \DateTime()
      ])
      ->getQuery()
      ->getResult();
  }

  public function findOldTokensByUserId(int $id): iterable{
    return $this->createQueryBuilder('a')
      ->leftJoin('a.user', 'u')
      ->where('u.id = :id')
      ->andWhere('a.expiresAt <= :expireDate')
      ->setParameters([
        'id' => $id,
        'expireDate' => new \DateTime()
      ])
      ->getQuery()
      ->getResult();
  }

  public function findByUserId(int $id): iterable{
    return $this->createQueryBuilder('a')
      ->leftJoin('a.user', 'u')
      ->where('u.id = :id')
      ->setParameter('id', $id)
      ->getQuery()
      ->getResult();
  }
}
