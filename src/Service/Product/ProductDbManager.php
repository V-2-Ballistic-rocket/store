<?php

namespace App\Service\Product;

use App\Entity\Product;
use App\Service\DbDto;
use PDO;

class ProductDbManager
{

    public function dbInit(DbDto $dto) : PDO
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

    public function getProduct(DbDto $dto) : ?Product
    {
        $result = $this->dbInit($dto)->query(
            "SELECT product_code, price, product_name, description FROM product WHERE product_id = {$dto->id};")
            ->fetch(PDO::PARAM_STR);

        if(!$result)
        {
            return null;
        }
        return ProductDataMapper::mapFromScheme($result);
    }

    public function addProduct(Product $product, DbDto $dto) : int
    {
        $DBH = $this->dbInit($dto);
        $DBH->query("INSERT INTO product (product_code, price, product_name, description)
        VALUES ('{$product->getCode()}', '{$product->getPrice()}', '{$product->getName()}', '{$product->getDescription()}');");
        
        return $DBH->lastInsertId();
    }

    public function editProduct(Product $product, DbDto $dto) : void
    {
        $this->dbInit($dto)->query(
            "UPDATE product
            SET product_code = '{$product->getCode()}', price = '{$product->getPrice()}', product_name = '{$product->getName()}', description = '{$product->getDescription()}'
            WHERE product_id = {$dto->id}");
    }

    public function deleteProduct(DbDto $dto) : void
    {
        $this->dbInit($dto)->query("DELETE FROM product WHERE product_id = {$dto->id}");
    }
}
