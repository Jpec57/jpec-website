<?php

namespace App\Service;

use App\Entity\Answer;
use App\Entity\Card;
use App\Entity\DTO\CardDTO;
use App\Repository\DeckRepository;
use Doctrine\ORM\EntityManagerInterface;

class CardService
{
  private $entityManager;
  private $deckRepository;

  public function __construct(EntityManagerInterface $entityManager, DeckRepository $deckRepository)
  {
    $this->entityManager = $entityManager;
    $this->deckRepository = $deckRepository;
  }

  public function createReversibleTextCardFromOriginal(Card $originalCard): Card
  {
    $card = clone $originalCard;

    // Invert language code
    $card->setLanguageCode($originalCard->getAnswerLanguageCode());
    $card->setAnswerLanguageCode($originalCard->getLanguageCode());

    // Invert question and answers
    $question = implode(', ', $originalCard->getAnswers());
    $card->setQuestion($question);
    $answer = new Answer();
    $answer->setText($originalCard->getQuestion());
    $answer->setCard($card);
    $card->addAnswer($answer);

    if (!$originalCard->getId()){
      $this->entityManager->persist($originalCard);
    }
    $this->entityManager->persist($card);
    $this->entityManager->flush();
    return $card;
  }

  public function createCardFromOriginal(CardDTO $cardDTO): Card
  {
    $deck = $this->deckRepository->find($cardDTO->getDeckId());
    if (!$deck){
      throw new \RuntimeException('No deck found with the id ' . $cardDTO->getDeckId());
    }
    $card = new Card();
    $card->setDeck($deck);
//    $card->setNextAvailable(time());
    $card->setQuestion($cardDTO->getQuestion());
    $card->setIsReversible($cardDTO->isReversible());
    $card->setLanguageCode($cardDTO->getLanguageCode());

    $this->entityManager->persist($card);
    $this->entityManager->flush();
    return $card;
  }
}