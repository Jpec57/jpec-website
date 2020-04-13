<?php

namespace App\Service;

use App\Repository\ApiTokenRepository;
use Doctrine\ORM\EntityManagerInterface;

class TokenService
{

  private $entityManager;
  private $apiTokenRepository;

  public function __construct(ApiTokenRepository $apiTokenRepository, EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
    $this->apiTokenRepository = $apiTokenRepository;
  }

  public function removeUserTokens(int $userId): void
  {
    $tokens = $this->apiTokenRepository->findByUserId($userId);
    foreach ($tokens as $token){
      $this->entityManager->remove($token);
    }
    $this->entityManager->flush();
  }

  public function removeOldTokensByUser(int $userId): void
  {
    $tokens = $this->apiTokenRepository->findOldTokensByUserId($userId);
    foreach ($tokens as $token){
      $this->entityManager->remove($token);
    }
    $this->entityManager->flush();
  }

  public function removeOldTokens(): void
  {
    $tokens = $this->apiTokenRepository->findOldTokens();
    foreach ($tokens as $token){
      $this->entityManager->remove($token);
    }
    $this->entityManager->flush();
  }
}