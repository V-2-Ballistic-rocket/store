<?php

namespace App\Service;

class DbDto
{
    public function __construct(
        public readonly string $database,
        public readonly string $host,
        public readonly string $dbName,
        public readonly string $user,
        public readonly string $password,
        public readonly string $toDbPath,
        public readonly int $id
    ) {

    }
}
