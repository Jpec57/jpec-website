<?php

namespace App\DTO;

use App\Entity\Card;

class CardDTO
{
  /**
   * @var string
   */
  private $question;

  /**
   * @var int
   */
  private $deckId;

  /**
   * @var int
   */
  private $languageCode = Card::LANGUAGE_JAPANESE_CODE;

  /**
   * @var int
   */
  private $answerLanguageCode = Card::LANGUAGE_ENGLISH_CODE;

  /**
   * @var boolean
   */
  private $isReversible = false;

  /**
   * @var string|null
   */
  private $hint;

  /**
   * @var array
   */
  private $answers;

  public function getQuestion(): string
  {
    return $this->question;
  }

  public function setQuestion(string $question): self
  {
    $this->question = $question;
    return $this;
  }

  public function getDeckId(): int
  {
    return $this->deckId;
  }

  public function setDeckId(int $deckId): self
  {
    $this->deckId = $deckId;
    return $this;
  }

  public function getLanguageCode(): int
  {
    return $this->languageCode;
  }

  public function setLanguageCode(int $languageCode): self
  {
    $this->languageCode = $languageCode;
    return $this;
  }

  public function isReversible(): bool
  {
    return $this->isReversible;
  }

  public function setIsReversible(bool $isReversible): self
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

  public function getAnswers(): array
  {
    return $this->answers;
  }

  public function setAnswers(array $answers): self
  {
    $this->answers = $answers;
    return $this;
  }

  public function getAnswerLanguageCode(): int
  {
    return $this->answerLanguageCode;
  }

  public function setAnswerLanguageCode(int $answerLanguageCode): self
  {
    $this->answerLanguageCode = $answerLanguageCode;
    return $this;
  }

}