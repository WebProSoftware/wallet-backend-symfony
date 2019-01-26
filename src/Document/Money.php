<?php
namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDb;
/**
 * @MongoDb\Document
 */
class Money {
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $created_at;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $updated_at;

    /**
     * @MongoDB\Field(type="float")
     */
    protected $amount_total;

    /**
     * @MongoDB\ReferenceMany(targetDocument="User", inversedBy="monies")
     */
    protected $User;

    /**
     * @MongoDB\ReferenceOne(targetDocument="MoneyDetails", cascade={"persist", "remove"})
     */
    protected $moneyDetails;

    /**
     * @MongoDB\ReferenceMany(targetDocument="MoneyCategory", mappedBy="monies")
     */
    protected $money_category;

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
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getAmountTotal()
    {
        return $this->amount_total;
    }

    /**
     * @param mixed $amount_total
     */
    public function setAmountTotal($amount_total)
    {
        $this->amount_total = $amount_total;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->User;
    }

    /**
     * @param mixed $User
     */
    public function setUser($User)
    {
        $this->User = $User;
    }

    /**
     * @return mixed
     */
    public function getMoneyDetails()
    {
        return $this->moneyDetails;
    }

    /**
     * @param mixed $moneyDetails
     */
    public function setMoneyDetails($moneyDetails)
    {
        $this->moneyDetails = $moneyDetails;
    }

    /**
     * @return mixed
     */
    public function getMoneyCategory()
    {
        return $this->money_category;
    }

    /**
     * @param mixed $money_category
     */
    public function setMoneyCategory($money_category)
    {
        $this->money_category = $money_category;
    }



}