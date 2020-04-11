<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnswerRepository")
 */
class Answer
{
  public const TYPE_TEXT = 0;
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   * @Groups({"card", "answer"})
   */
  private $id;

  /**
   * @Groups({"deck", "card", "answer"})
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $text;

  /**
   * @Groups({"deck", "card", "answer"})
   * @ORM\Column(type="integer")
   */
  private $type = 0;

  /**
   * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="answers")
   * @ORM\JoinColumn(nullable=false)
   */
  private $card;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId($id): self
  {
    $this->id = $id;
    return $this;
  }

  public function getText(): ?string
  {
    return $this->text;
  }

  public function setText(?string $text): self
  {
    $this->text = $text;

    return $this;
  }

  public function getType(): ?int
  {
    return $this->type;
  }

  public function setType(int $type): self
  {
    $this->type = $type;

    return $this;
  }

  public function getCard(): ?Card
  {
    return $this->card;
  }

  public function setCard(?Card $card): self
  {
    $this->card = $card;

    return $this;
  }
}
