<?php

namespace App\common\Validators;

use App\Entity\User;

class UserValidator
{
    protected const CURRENT_NUMB_OF_FIELDS = 3;
    private const LOGIN_MAX_LENGTH = 30;
    private const INN_MAX_LENGTH = 12;
    private const KPP_MAX_LENGTH = 9;

    public function isValidUser(User $user): bool
    {
        if(!$this->innIsValid($user->getInn()))
        {
            return false;
        }
        if(!$this->loginIsValid($user->getLogin()))
        {
            return false;
        }
        if(!$this->kppIsValid($user->getKpp()))
        {
            return false;
        }
        return true;
    }

    public function loginIsValid($login) : bool
    {
        if(strlen($login) > self::LOGIN_MAX_LENGTH)
        {
            return false;
        }
        return true;
    }

    public function innIsValid($inn) : bool
    {
        if(!is_numeric($inn))
        {
            return false;
        }
        if(strlen($inn) > self::INN_MAX_LENGTH)
        {
            return false;
        }
        return true;
    }

    public function kppIsValid($kpp) : bool
    {
        if(!is_numeric($kpp))
        {
            return false;
        }
        if(strlen($kpp) > self::KPP_MAX_LENGTH)
        {
            return false;
        }
        return true;
    }
}
