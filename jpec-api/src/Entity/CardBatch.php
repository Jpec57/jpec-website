<?php

namespace App\Entity;


class CardBatch
{
    private $cardId;

    private $isSuccess;

    private $cardBatchMeta;

    public function getCardId(): ?int
    {
        return $this->cardId;
    }

    public function setCardId(int $cardId): self
    {
        $this->cardId = $cardId;

        return $this;
    }

    public function getIsSuccess(): ?bool
    {
        return $this->isSuccess;
    }

    public function setIsSuccess(bool $isSuccess): self
    {
        $this->isSuccess = $isSuccess;

        return $this;
    }

    public function getCardBatchMeta(): ?CardBatchMeta
    {
        return $this->cardBatchMeta;
    }

    public function setCardBatchMeta(?CardBatchMeta $cardBatchMeta): self
    {
        $this->cardBatchMeta = $cardBatchMeta;

        return $this;
    }
}
