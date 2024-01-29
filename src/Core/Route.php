<?php
namespace App\Core;


use App\Core\Body;
use App\Controller\EntityControllerInterface;

class Route{
    
    private array $methods = [];

    function __construct(
        private string $uri,
        private EntityControllerInterface $controller,
        private Body $body
    ){

    }

    public function addMethod(string $method,string $action) : void 
    {
        $this->methods = array_merge($this->methods, [$method => $action]);
    }

    public function getMethods():array{
        return $this->methods;
    }

    public function getUri():string{
        return "/" . $this->uri;
    }

    public function getController() : EntityControllerInterface {
        return $this->controller;
    }
    
    public function getBody(): Body{
        return $this->body;
    }
}