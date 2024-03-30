<?php

namespace App\Core;

use App\Service\DbDto;

class Body
{
    public function __construct(
        private ?array $phpInputData,
        private DbDto $dBDTO
        )
    {}

    public function getPhpInputData() : array
    {
        return $this->phpInputData;
    }

    public function getDBDTO() : DbDto
    {
        return $this->dBDTO;
    }
}
