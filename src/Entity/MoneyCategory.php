<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MoneyCategoryRepository")
 */
class MoneyCategory
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
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $distance;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MoneyType", inversedBy="moneyType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $money_type;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getDistance(): ?bool
    {
        return $this->distance;
    }

    public function setDistance(bool $distance): self
    {
        $this->distance = $distance;

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

    public function __toString()
    {
        return $this->name;
    }

}
