<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserCardInfoRepository")
 */
class UserCardInfo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userCardInfos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbErrors = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbSuccess = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card", inversedBy="userCardInfos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $card;

    /**
     * @ORM\Column(type="datetime")
     */
    private $nextAvailable;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Answer", mappedBy="userCardInfo")
     */
    private $userAnswers;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $userNote;

    /**
     * @ORM\Column(type="integer")
     */
    private $level = 0;

    public function __construct()
    {
        $this->userAnswers = new ArrayCollection();
        $this->nextAvailable = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getNbErrors(): ?int
    {
        return $this->nbErrors;
    }

    public function setNbErrors(int $nbErrors): self
    {
        $this->nbErrors = $nbErrors;

        return $this;
    }

    public function getNbSuccess(): ?int
    {
        return $this->nbSuccess;
    }

    public function setNbSuccess(int $nbSuccess): self
    {
        $this->nbSuccess = $nbSuccess;

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

    public function getNextAvailable(): ?\DateTimeInterface
    {
        return $this->nextAvailable;
    }

    public function setNextAvailable(\DateTimeInterface $nextAvailable): self
    {
        $this->nextAvailable = $nextAvailable;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getUserAnswers(): Collection
    {
        return $this->userAnswers;
    }

    public function addUserAnswer(Answer $userAnswer): self
    {
        if (!$this->userAnswers->contains($userAnswer)) {
            $this->userAnswers[] = $userAnswer;
            $userAnswer->setUserCardInfo($this);
        }

        return $this;
    }

    public function removeUserAnswer(Answer $userAnswer): self
    {
        if ($this->userAnswers->contains($userAnswer)) {
            $this->userAnswers->removeElement($userAnswer);
            // set the owning side to null (unless already changed)
            if ($userAnswer->getUserCardInfo() === $this) {
                $userAnswer->setUserCardInfo(null);
            }
        }

        return $this;
    }

    public function getUserNote(): ?string
    {
        return $this->userNote;
    }

    public function setUserNote(?string $userNote): self
    {
        $this->userNote = $userNote;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }
}
