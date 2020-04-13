<?php

namespace App\Service;

use App\Repository\DeckRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeckService
{
  private $entityManager;

  public function __construct(EntityManagerInterface $entityManager, DeckRepository $deckRepository)
  {
    $this->entityManager = $entityManager;
  }

}