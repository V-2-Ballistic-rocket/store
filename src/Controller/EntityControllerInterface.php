<?php

namespace App\Controller;


use Generator;
use App\Core\Body;

interface EntityControllerInterface
{
    public function getEntity(Body $body):object;
    public function addEntity(Body $body):void;
    public function deleteEntity(Body $body):void;
    public function editEntity(Body $body):void;
}