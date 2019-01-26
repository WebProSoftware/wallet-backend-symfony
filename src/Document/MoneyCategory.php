<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDb;

/**
 * @MongoDb\Document
 */
class MoneyCategory
{
    /**
     * @MongoDb\Id
     */
    protected $id;

    /**
     * @MongoDb\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDb\Field(type="string")
     */
    protected $description;

    /**
     * @MongoDb\Field(type="float")
     */
    protected $distance;

    /**
     * @MongoDb\ReferenceOne(targetDocument="MoneyType", inversedBy="moneyType")
     */
    protected $money_type;

    /**
     * @MongoDb\ReferenceMany(targetDocument="Money", mappedBy="money_category")
     */
    protected $monies;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return mixed
     */
    public function getMoneyType()
    {
        return $this->money_type;
    }

    /**
     * @param mixed $money_type
     */
    public function setMoneyType($money_type)
    {
        $this->money_type = $money_type;
    }

    /**
     * @return mixed
     */
    public function getMonies()
    {
        return $this->monies;
    }

    /**
     * @param mixed $monies
     */
    public function setMonies($monies)
    {
        $this->monies = $monies;
    }


}