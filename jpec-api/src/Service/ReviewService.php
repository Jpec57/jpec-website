<?php

namespace App\Service;

use App\Entity\CardBatch;
use App\Entity\User;
use App\Entity\UserCardInfo;
use App\Repository\CardRepository;
use App\Repository\UserCardInfoRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

class ReviewService
{
  private $entityManager;
  private $cardRepository;
  private $userCardInfoRepository;
  private $logger;

  public function __construct(EntityManagerInterface $entityManager, CardRepository $cardRepository,
                              UserCardInfoRepository $userCardInfoRepository, LoggerInterface $logger)
  {
    $this->entityManager = $entityManager;
    $this->cardRepository = $cardRepository;
    $this->userCardInfoRepository = $userCardInfoRepository;
    $this->logger = $logger;
  }

  /**
   * @param int $level
   * @return \DateTime
   * @throws \Exception
   */
  public function getNextAvailableByLevel(int $level): \DateTime
  {
    switch ($level) {
      case 0:
        return new \DateTime('+4 hours');
      case 1:
        return new \DateTime('+8 hours');
      case 2:
        return new \DateTime('+1 day');
      case 3:
        return new \DateTime('+2 days');
      case 4:
        return new \DateTime('+1 week');
      case 5:
        return new \DateTime('+2 weeks');
      case 6:
        return new \DateTime('+1 month');
      case 7:
        return new \DateTime('+2 months');
      case 8:
        return new \DateTime('+4 months');
      case 9:
        return new \DateTime('+1 year');
      default:
        return new \DateTime('+1 year');
    }
  }

  /**
   * @param UserCardInfo $userCardInfo
   * @param bool $isSuccess
   * @return UserCardInfo
   */
  public function updateUserCardInfo(UserCardInfo $userCardInfo, bool $isSuccess): UserCardInfo
  {
    $lvl = $userCardInfo->getLevel();
    $nbErrors = $userCardInfo->getNbErrors();
    $nbSuccess = $userCardInfo->getNbSuccess();
    $nextAvailable = $userCardInfo->getNextAvailable();

    if ($isSuccess) {
      $nbSuccess++;
      $lvl++;
    } else {
      $nbErrors++;
      $lvl -= (($lvl >= 5) ? 2 : 1);
      if ($lvl < 0) {
        $lvl = 0;
      }
    }
    try {
      $nextAvailable = $this->getNextAvailableByLevel($lvl);
    } catch (\Exception $e) {
      $this->logger->error('Next available could not be generated');
    }

    $userCardInfo
      ->setLevel($lvl)
      ->setNbErrors($nbErrors)
      ->setNbSuccess($nbSuccess)
      ->setNextAvailable($nextAvailable);

    return $userCardInfo;
  }

  /**
   * @param CardBatch[] $cardArray
   * @param User $user
   * @return array
   * @throws \Exception
   */
  public function reviewCards(array $cardArray, User $user): array
  {
    $userId = $user->getId();
    $cardErrors = [];

    $cardIds = array_map(function (CardBatch $card) {
      return $card->getCardId();
    }, $cardArray);

    $cards = $this->cardRepository->findBy(['id' => $cardIds]);
    /** @var Collection<UserCardInfo> $userCardInfos */
    $userCardInfos = $this->userCardInfoRepository->findByIdsForUser($cardIds, $userId);

    foreach ($cards as $card) {
      $cardId = $card->getId();

      $requestCardResult = null;
      foreach ($cardArray as $requestCard){
        $requestCardId = $requestCard->getCardId();
        if ($requestCardId === $cardId){
          $requestCardResult = $requestCard;
          break;
        }
      }

      if (!$requestCardResult) {
        $this->logger->error('An error has occurred while trying to find a cardId in request', ['cardId' => $cardId]);
        $cardErrors[$cardId] = 'cardId is not found in request.';
        continue;
      }
      $isSuccess = $requestCardResult->getIsSuccess();

      if ($isSuccess === null) {
        $cardErrors[$cardId] = 'isSuccess cannot be null';
        $this->logger->error('Incomplete card review: isSuccess cannot be null.', ['cardId' => $cardId]);
        continue;
      }

      $userCardInfo = null;
      foreach ($userCardInfos as $cardInfo){
        if ($cardInfo->getId() === $cardId){
          $userCardInfo = $cardInfo;
          break;
        }
      }

      $isUserCardInfoExisting = (!$userCardInfo);
      //Create all UserCardInfo not already existing for user
      if ($isUserCardInfoExisting) {
        $userCardInfo = new UserCardInfo();
        $userCardInfo->setCard($card)
          ->setUser($user);
      }

      if ($userCardInfo->getNextAvailable() > new \DateTime()){
        $cardErrors[$cardId] = 'Cannot update a card before its review date';
        continue;
      }
      $userCardInfo = $this->updateUserCardInfo($userCardInfo, $isSuccess);

      if ($isUserCardInfoExisting) {
        $this->entityManager->merge($userCardInfo);
      } else {
        $this->entityManager->persist($userCardInfo);
      }
    }

    $this->entityManager->flush();
    return $cardErrors;
  }
}