<?php

namespace App\DataFixtures;

use App\Entity\Deck;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DeckFixtures extends Fixture
{

  public function load(ObjectManager $manager)
  {

    $deck = new Deck();
    $deck->setDescription('This is the default deck');
    $deck->setTitle('Default');
    $deck->setAuthor('Jpec');
    $manager->persist($deck);
    $this->addReference('DECK_1', $deck);


    $deck = new Deck();
    $deck->setDescription('This is my first personal deck');
    $deck->setTitle('Deck 1');
    $deck->setAuthor('Jpec');
    $manager->persist($deck);
    $this->addReference('DECK_2', $deck);

    $deck = new Deck();
    $deck->setTitle('Second Deck');
    $deck->setAuthor('Jpec');
    $manager->persist($deck);
    $this->addReference('DECK_3', $deck);

    $manager->flush();
  }
}
