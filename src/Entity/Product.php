<?php
namespace App\Entity;

Class Product{

    function __construct(
        private string $code,
        private string $price,
        private string $name,
        private string $description
    )
    {}
    
    public static function createProductByAssocArr(array $data) : Product
    {
        $product = new Product($data['product_code'], $data['price'], $data['product_name'], $data['description']);
        return $product;
    }

    public function getCode():string{
        return $this->code;
    }

    public function getPrice():string{
        return $this->price;
    }

    public function getName():string{
        return $this->name;
    }

    public function getDescription():string{
        return $this->description;
    }

    public function setCode(string $code):self{
        $this->code = $code;
        return $this;
    }

    public function setPrice(string $price):self{
        $this->price = $price;
        return $this;
    }

    public function setName(string $name):self{
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description):self{
        $this->description = $description;
        return $this;
    }

    public function getArray():array
    {
        return array($this->getCode(), $this->getPrice(), $this->getName(), $this->getDescription());
    }
}
