<?php

namespace App\DTO;

class DeckDTO
{
  /**
   * @var string
   */
  private $title;

  /**
   * @var string
   */
  private $author;

  /**
   * @var string|null
   */
  private $description;

  public function getTitle(): string
  {
    return $this->title;
  }

  public function setTitle(string $title): self
  {
    $this->title = $title;
    return $this;
  }

  public function getAuthor(): string
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
}