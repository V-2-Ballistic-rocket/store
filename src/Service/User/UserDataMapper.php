<?php

namespace App\Service\User;

use App\Entity\User;

class UserDataMapper
{
    static public function mapFromScheme(array $userScheme) : User
    {
        return new User($userScheme['login'], $userScheme['inn'], $userScheme['kpp']);
    }

    static public function mapToScheme(User $user) : array
    {
        return [
            'login' => $user->getLogin(),
            'inn' => $user->getInn(),
            'kpp' => $user->getKpp()
        ];
    }
}