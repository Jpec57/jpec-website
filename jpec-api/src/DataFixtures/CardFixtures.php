<?php

namespace App\DataFixtures;

use App\Entity\Card;
use App\Repository\DeckRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CardFixtures extends Fixture implements DependentFixtureInterface
{

  public function load(ObjectManager $manager)
  {
    /**
     * FIRST DECK
     */

    /**
     * ENGLISH CARDS
     */
    $card = new Card();
    $card->setDeck($this->getReference('DECK_1'));
    $card->setNextAvailable(100);
    $card->setQuestion('How are you ?');
    $card->setIsReversible(true);
    $card->setLanguageCode(Card::LANGUAGE_ENGLISH_CODE);
    $card->setAnswerLanguageCode(Card::LANGUAGE_JAPANESE_CODE);
    $manager->persist($card);
    $this->addReference('CARD_1', $card);


    /**
     * JAPANESE CARDS
     */
    // 大丈夫
    $card = new Card();
    $card->setDeck($this->getReference('DECK_1'));
    $card->setNextAvailable(100);
    $card->setQuestion('大丈夫?');
    $card->setHint('だいじょうぶ');
    $card->setIsReversible(true);
    $card->setLanguageCode(Card::LANGUAGE_JAPANESE_CODE);
    $card->setAnswerLanguageCode(Card::LANGUAGE_ENGLISH_CODE);
    $manager->persist($card);
    $this->addReference('CARD_2', $card);

    $manager->flush();
  }

  public function getDependencies()
  {
    return array(
      DeckFixtures::class,
    );
  }
}
