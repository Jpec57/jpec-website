<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{

  /**
   * This method must return an array of fixtures classes
   * on which the implementing class depends on
   *
   * @return array class-string[]
   */
  public function getDependencies()
  {
    return [
      CardFixtures::class
    ];
  }

  /**
   * Load data fixtures with the passed EntityManager
   */
  public function load(ObjectManager $manager)
  {

    /**
     * Deck 1
     */

    //card 1
    $answer = new Answer();
    $answer->setText('いい');
    $answer->setCard($this->getReference('CARD_1'));
    $manager->persist($answer);
    $this->addReference('ANSWER_1', $answer);


    $answer = new Answer();
    $answer->setText('いいえ');
    $answer->setCard($this->getReference('CARD_1'));
    $manager->persist($answer);
    $this->addReference('ANSWER_2', $answer);

    //card 2
    $answer = new Answer();
    $answer->setText('いいえ');
    $answer->setCard($this->getReference('CARD_2'));
    $manager->persist($answer);
    $this->addReference('ANSWER_3', $answer);

    $manager->flush();
  }
}