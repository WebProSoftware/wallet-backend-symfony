<?php

namespace App\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDb;
/**
 * @MongoDb\Document
 */
class User {
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $email;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $password;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $salt;

    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $active;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $created_at;

    /**
     * @MongoDb\Field(type="date")
     */
    protected $updated_at;

    /**
     * @MongoDB\Field(type="boolean")
     */
    protected $blocked;

    /**
     * @MongoDB\Field(type="date", nullable=true)
     */
    protected $last_access;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $token;

    /**
     * @MongoDB\ReferenceOne(targetDocument="UserAddress", cascade={"persist", "remove"})
     */
    protected $UserAdress;

    /**
     * @MongoDB\ReferenceOne(targetDocument="UserDetails", cascade={"persist", "remove"})
     */
    protected $UserDetails;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Money", mappedBy="user")
     */
    protected $monies = [];

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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
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
    public function getBlocked()
    {
        return $this->blocked;
    }

    /**
     * @param mixed $blocked
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;
    }

    /**
     * @return mixed
     */
    public function getLastAccess()
    {
        return $this->last_access;
    }

    /**
     * @param mixed $last_access
     */
    public function setLastAccess($last_access)
    {
        $this->last_access = $last_access;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getUserAdress()
    {
        return $this->UserAdress;
    }

    /**
     * @param mixed $UserAdress
     */
    public function setUserAdress($UserAdress)
    {
        $this->UserAdress = $UserAdress;
    }

    /**
     * @return mixed
     */
    public function getUserDetails()
    {
        return $this->UserDetails;
    }

    /**
     * @param mixed $UserDetails
     */
    public function setUserDetails($UserDetails)
    {
        $this->UserDetails = $UserDetails;
    }

    /**
     * @return mixed
     */
    public function getMonies()
    {
        return $this->monies;
    }


    public function addMoney(Money $money): self
    {
        if (!$this->monies->contains($money)) {
            $this->monies[] = $money;
            $money->setUser($this);
        }

        return $this;
    }

    public function removeMoney(Money $money): self
    {
        if ($this->monies->contains($money)) {
            $this->monies->removeElement($money);
            // set the owning side to null (unless already changed)
            if ($money->getUser() === $this) {
                $money->setUser(null);
            }
        }

        return $this;
    }

    public function __construct()
    {
        $this->blocked = false;
        $this->monies = new ArrayCollection();
    }


}
