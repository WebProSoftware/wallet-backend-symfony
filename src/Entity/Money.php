<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MoneyRepository")
 */
class Money
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount_total;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="monies")
     */
    private $User;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MoneyDetails", cascade={"persist", "remove"})
     */
    private $moneyDetails;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MoneyCategory", inversedBy="monies")
     */
    private $money_category;


    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getAmountTotal(): ?float
    {
        return $this->amount_total;
    }

    public function setAmountTotal(?float $amount_total): self
    {
        $this->amount_total = $amount_total;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->id;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getMoneyDetails(): ?MoneyDetails
    {
        return $this->moneyDetails;
    }

    public function setMoneyDetails(?MoneyDetails $moneyDetails): self
    {
        $this->moneyDetails = $moneyDetails;

        return $this;
    }

    public function getMoneyCategory(): ?MoneyCategory
    {
        return $this->money_category;
    }

    public function setMoneyCategory(?MoneyCategory $money_category): self
    {
        $this->money_category = $money_category;

        return $this;
    }


}
