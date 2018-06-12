<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MoneyDetailsRepository")
 */
class MoneyDetails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $amount_item;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Money", inversedBy="money")
     * @ORM\JoinColumn(nullable=true)
     */
    private $money;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

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

    public function getAmountItem(): ?string
    {
        return $this->amount_item;
    }

    public function setAmountItem(?string $amount_item): self
    {
        $this->amount_item = $amount_item;

        return $this;
    }

    public function getMoney()
    {
        return $this->money;
    }

    public function setMoney(Money $money)
    {
        $this->money = $money;

        return $this;
    }
}
