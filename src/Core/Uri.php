<?php

namespace App\Core;

class Uri
{
    private int $id;
    private string $uri;
    public function __construct(string $uri)
    {
        $uri = explode('/', $uri);
        $this->id = isset($uri[2]) && is_numeric($uri[2]) ? $uri[2] : 0;
        $this->uri = $uri[1];
    }

    public function getUri(): string {
        return '/' . $this->uri;
    }

    public function getId(): int { 
        return $this->id;
    }
}
