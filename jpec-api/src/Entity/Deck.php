<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeckRepository")
 */
class Deck
{
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @Assert\NotBlank(groups={"UpdateDeck"})
   * @ORM\Column(type="integer")
   * @Groups({"deck", "card"})
   */
  private $id;

  /**
   * @Assert\NotBlank
   * @ORM\Column(type="string", length=255)
   * @Groups({"deck"})
   */
  private $title;

  /**
   * @Assert\NotBlank
   * @ORM\Column(type="string", length=255)
   * @Groups({"deck"})
   */
  private $author;

  /**
   * @Groups({"deck"})
   * @ORM\Column(type="string", length=255, nullable=true)
   */
  private $description;

  /**
   * @Groups({"deck"})
   * @ORM\OneToMany(targetEntity="App\Entity\Card", mappedBy="deck", orphanRemoval=true)
   */
  private $cards;

  public function __construct()
  {
    $this->cards = new ArrayCollection();
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

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title): self
  {
    $this->title = $title;

    return $this;
  }

  public function getAuthor(): ?string
  {
    return $this->author;
  }

  public function setAuthor(string $author): self
  {
    $this->author = $author;

    return $this;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(?string $description): self
  {
    $this->description = $description;

    return $this;
  }

  /**
   * @return Collection|Card[]
   */
  public function getCards(): Collection
  {
    return $this->cards;
  }

  public function addCard(Card $card): self
  {
    if (!$this->cards->contains($card)) {
      $this->cards[] = $card;
      $card->setDeck($this);
    }

    return $this;
  }

  public function removeCard(Card $card): self
  {
    if ($this->cards->contains($card)) {
      $this->cards->removeElement($card);
      // set the owning side to null (unless already changed)
      if ($card->getDeck() === $this) {
        $card->setDeck(null);
      }
    }

    return $this;
  }


}
