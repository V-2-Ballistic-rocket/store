<?php

namespace App\Core;

use App\Service\DBDTO;

class Body
{
    public function __construct(
        private ?array $phpInputData,
        private DBDTO $dBDTO
        )
    {}

    public function getPhpInputData() : array
    {
        return $this->phpInputData;
    }

    public function getDBDTO() : DBDTO
    {
        return $this->dBDTO;
    }
}
