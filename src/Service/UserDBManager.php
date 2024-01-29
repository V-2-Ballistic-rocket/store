<?php

namespace App\Service;

use PDO;
use App\Entity\User;
use App\Core\HttpCode;
use App\Service\DBDTO;
use App\Service\UserDataMapper;

class UserDBManager
{

    public function dbInit(DBDTO $dto) : PDO
    {
        $DBH = new PDO
        (
            "{$dto->database}:
            host= {$dto->host};
            dbname={$dto->dbName}", 
            $dto->user, 
            $dto->password
        );
        $DBH->exec(file_get_contents($dto->toDbPath));

        return $DBH;
    }

    public function getUser(DBDTO $dto) : ?User
    {
        $result = $this->dbInit($dto)->query(
            "SELECT login, inn, kpp FROM users WHERE user_id = {$dto->id};")
            ->fetch(PDO::PARAM_STR);

        if(!$result)
        {
            return null;
        }
        return UserDataMapper::mapFromScheme($result);
    }

    public function addUser(User $user, DBDTO $dto) : int
    {
        $DBH = $this->dbInit($dto);
        $DBH->query("INSERT INTO users (login, inn, kpp)
        VALUES ('{$user->getLogin()}', '{$user->getInn()}', '{$user->getKpp()}');");

        return $DBH->lastInsertId();
    }

    public function editUser(User $user,DBDTO $dto) : void
    {
        $this->dbInit($dto)->query(
            "UPDATE users
            SET login = '{$user->getLogin()}', inn = '{$user->getInn()}', kpp = '{$user->getKpp()}'
            WHERE user_id = {$dto->id}");
    }

    public function deleteUser(DBDTO $dto) : void
    {
        $this->dbInit($dto)->query("DELETE FROM users WHERE user_id = {$dto->id}");
    }
}
