<?php

namespace App\Entity;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\MoneyType", inversedBy="moneyType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $money_type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MoneyCategory", inversedBy="moneyCategory")
     * @ORM\JoinColumn(nullable=true)
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

    public function getMoneyType()
    {
        return $this->money_type;
    }

    public function setMoneyType(MoneyType $moneyType)
    {
        $this->money_type = $moneyType;

        return $this;
    }

    public function getMoneyCategory()
    {
        return $this->money_category;
    }

    public function setMoneyCategory(MoneyCategory $moneyCategory)
    {
        $this->money_category = $moneyCategory;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}
