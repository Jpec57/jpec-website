<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class CardBatchMeta
{

    private $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    /**
     * @return CardBatch[]
     */
    public function getCards(): iterable
    {
        return $this->cards->toArray();
    }

    public function addCard(CardBatch $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards[] = $card;
            $card->setCardBatchMeta($this);
        }

        return $this;
    }

    public function removeCard(CardBatch $card): self
    {
        if ($this->cards->contains($card)) {
            $this->cards->removeElement($card);
            // set the owning side to null (unless already changed)
            if ($card->getCardBatchMeta() === $this) {
                $card->setCardBatchMeta(null);
            }
        }

        return $this;
    }
}
