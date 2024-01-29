<?php

namespace App\Service\Validator\User;

use App\Service\Validator\User\UserValidator;

class UserSchemeValidator extends UserValidator
{
    public function isValidScheme(array $data) : bool
    {
        if(!isset($data))
        {
            return false;
        }
        if(count($data) != self::CURRENT_NUMB_OF_FIELDS)
        {
            return false;
        }
        if(!$this->loginIsValid($data['login']))
        {
            return false;
        }
        if(!$this->innIsValid($data['inn']))
        {
            return false;
        }
        if(!$this->kppIsValid($data['kpp']))
        {
            return false;
        }
        return true;
    }
}
