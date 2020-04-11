<?php

namespace App\Service;

use App\DTO\DeckDTO;
use App\Entity\Deck;
use App\Repository\DeckRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeckService
{
  private $entityManager;

  public function __construct(EntityManagerInterface $entityManager, DeckRepository $deckRepository)
  {
    $this->entityManager = $entityManager;
  }

  public function formatDeck(array $deckValues): Deck
  {
    $deck = new Deck();
    $deck->setAuthor($deckValues['author'] ?? null);
    $deck->setTitle($deckValues['title'] ?? null);
    $deck->setDescription($deckValues['description'] ?? null);
    return $deck;
  }

  public function createDeck(DeckDTO $deckDTO): Deck
  {
    $deck = new Deck();
    $deck->setAuthor($deckDTO->getAuthor());
    $deck->setTitle($deckDTO->getTitle());
    $deck->setDescription($deckDTO->getDescription());
    $this->entityManager->persist($deck);
    $this->entityManager->flush();
    return $deck;
  }
}