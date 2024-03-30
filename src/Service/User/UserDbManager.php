<?php

namespace App\Service\User;

use App\Entity\User;
use App\Service\DbDto;
use PDO;

class UserDbManager
{

    public function dbInit(DbDto $dto): PDO
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

    public function getUser(DbDto $dto): ?User
    {
        $result = $this->dbInit($dto)->query(
            "SELECT login, inn, kpp FROM users WHERE user_id = {$dto->id};")
            ->fetch(PDO::PARAM_STR);

        if (!$result) {
            return null;
        }
        return UserDataMapper::mapFromScheme($result);
    }

    public function addUser(User $user, DbDto $dto): int
    {
        $DBH = $this->dbInit($dto);
        $DBH->query("INSERT INTO users (login, inn, kpp)
        VALUES ('{$user->getLogin()}', '{$user->getInn()}', '{$user->getKpp()}');");

        return $DBH->lastInsertId();
    }

    public function editUser(User $user, DbDto $dto): void
    {
        $this->dbInit($dto)->query(
            "UPDATE users
            SET login = '{$user->getLogin()}', inn = '{$user->getInn()}', kpp = '{$user->getKpp()}'
            WHERE user_id = {$dto->id}");
    }

    public function deleteUser(DbDto $dto): void
    {
        $this->dbInit($dto)->query("DELETE FROM users WHERE user_id = {$dto->id}");
    }
}
