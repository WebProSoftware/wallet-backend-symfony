<?php

namespace App\Document;


use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDb;
/**
 * @MongoDb\Document
 */
class UserAddress {
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $city;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $post_code;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $street;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $number_local;

    /** @MongoDB\ReferenceOne(targetDocument="User") */
    protected $User;

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
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getPostCode()
    {
        return $this->post_code;
    }

    /**
     * @param mixed $post_code
     */
    public function setPostCode($post_code)
    {
        $this->post_code = $post_code;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param mixed $street
     */
    public function setStreet($street)
    {
        $this->street = $street;
    }

    /**
     * @return mixed
     */
    public function getNumberLocal()
    {
        return $this->number_local;
    }

    /**
     * @param mixed $number_local
     */
    public function setNumberLocal($number_local)
    {
        $this->number_local = $number_local;
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

}