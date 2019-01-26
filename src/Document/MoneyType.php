<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDb;

/**
 * @MongoDb\Document
 */
class MoneyType {
    /**
     * @MongoDb\Id()
     */
    private $id;

    /**
     * @MongoDb\Field(type="string")
     */
    private $name;

    /**
     * @MongoDb\Field(type="string")
     */
    private $short_name;

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
    public function getShortName()
    {
        return $this->short_name;
    }

    /**
     * @param mixed $short_name
     */
    public function setShortName($short_name)
    {
        $this->short_name = $short_name;
    }



}