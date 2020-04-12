<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CardRepository")
 */
class Card
{
  public const LANGUAGE_ENGLISH_CODE = 0;
  public const LANGUAGE_JAPANESE_CODE = 1;
  public const LANGUAGE_FRENCH_CODE = 2;

  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   * @Groups({"deck", "card"})
   */
  private $id;

  /**
   * @ORM\Column(type="integer")
   * @Groups({"deck", "card"})
   */
  private $nextAvailable;

  /**
   * @ORM\Column(type="string", length=255)
   * @Groups({"deck", "card"})
   */
  private $question;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\Deck", inversedBy="cards")
   * @ORM\JoinColumn(nullable=false)
   * @Groups({"card"})
   */
  private $deck;

  /**
   * @ORM\Column(type="integer")
   * @Groups({"deck", "card"})
   */
  private $languageCode = self::LANGUAGE_JAPANESE_CODE;

  /**
   * @Groups({"deck", "card"})
   * @ORM\Column(type="integer")
   */
  private $answerLanguageCode = self::LANGUAGE_ENGLISH_CODE;

  /**
   * @Groups({"deck", "card"})
   * @ORM\Column(type="boolean")
   */
  private $isReversible;

  /**
   * @Groups({"deck", "card"})
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $hint;

  /**
   * @Groups({"deck", "card"})
   * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="card", orphanRemoval=true, cascade={"persist"})
   */
  private $answers;



  public function __construct()
  {
    $this->nextAvailable = time();
    $this->answers = new ArrayCollection();
    $this->languageCode = self::LANGUAGE_JAPANESE_CODE;
    $this->answerLanguageCode = self::LANGUAGE_ENGLISH_CODE;
  }

  public function setId($id): self
  {
    $this->id = $id;
    return $this;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getNextAvailable(): ?int
  {
    return $this->nextAvailable;
  }

  public function setNextAvailable(?int $nextAvailable): self
  {
    $this->nextAvailable = $nextAvailable;

    return $this;
  }

  public function getQuestion(): ?string
  {
    return $this->question;
  }

  public function setQuestion(string $question): self
  {
    $this->question = $question;

    return $this;
  }

  public function getDeck(): ?Deck
  {
    return $this->deck;
  }

  public function setDeck(?Deck $deck): self
  {
    $this->deck = $deck;

    return $this;
  }

  public function getLanguageCode(): ?int
  {
    return $this->languageCode;
  }

  public function setLanguageCode(?int $languageCode): self
  {
    $this->languageCode = $languageCode;

    return $this;
  }

  public function getIsReversible(): ?bool
  {
    return $this->isReversible;
  }

  public function setIsReversible(?bool $isReversible): self
  {
    $this->isReversible = $isReversible;

    return $this;
  }

  public function getHint(): ?string
  {
    return $this->hint;
  }

  public function setHint(?string $hint): self
  {
    $this->hint = $hint;

    return $this;
  }

  /**
   * @return Collection|Answer[]
   */
  public function getAnswers(): Collection
  {
    return $this->answers;
  }

  public function addAnswer(Answer $answer): self
  {
    if (!$this->answers->contains($answer)) {
      $this->answers[] = $answer;
      $answer->setCard($this);
    }

    return $this;
  }

  public function removeAnswer(Answer $answer): self
  {
    if ($this->answers->contains($answer)) {
      $this->answers->removeElement($answer);
      // set the owning side to null (unless already changed)
      if ($answer->getCard() === $this) {
        $answer->setCard(null);
      }
    }

    return $this;
  }

  public function getAnswerLanguageCode(): ?int
  {
      return $this->answerLanguageCode;
  }

  public function setAnswerLanguageCode(?int $answerLanguageCode): self
  {
      $this->answerLanguageCode = $answerLanguageCode;

      return $this;
  }
}
