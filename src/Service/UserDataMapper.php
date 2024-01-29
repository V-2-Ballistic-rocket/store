<?php

namespace App\Service;

use App\Entity\User;

class UserDataMapper
{
    static public function mapFromScheme(array $userScheme) : User
    {
        return new User($userScheme['login'], $userScheme['inn'], $userScheme['kpp']);
    }

    static public function mopToScheme(User $user) : array
    {
        return array
        (
            'login' => $user->getLogin(),
            'inn' => $user->getInn(),
            'kpp' => $user->getKpp()
        );
    }
}