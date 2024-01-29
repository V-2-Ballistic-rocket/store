<?php

namespace App\Entity;

class User
{

    function __construct(
        private string $login,
        private string $inn,
        private string $kpp
    )
    {}

    public static function createUserByAssocArr(array $data):User{
        return new User($data['login'], $data['inn'], $data['kpp']);
    }

    /**
     * Get the value of kpp
     */ 
    public function getKpp()
    {
        return $this->kpp;
    }

    /**
     * Set the value of kpp
     *
     * @return  self
     */ 
    public function setKpp($kpp)
    {
        $this->kpp = $kpp;

        return $this;
    }

    /**
     * Get the value of inn
     */ 
    public function getInn()
    {
        return $this->inn;
    }

    /**
     * Set the value of inn
     *
     * @return  self
     */ 
    public function setInn($inn)
    {
        $this->inn = $inn;

        return $this;
    }

    /**
     * Get the value of login
     */ 
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set the value of login
     *
     * @return  self
     */ 
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    public function getArray():array
    {
        return array($this->getLogin(), $this->getInn(), $this->getKpp());
    }
}
