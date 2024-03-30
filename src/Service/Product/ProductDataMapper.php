<?php

namespace App\Service\Product;

use App\Entity\Product;

class ProductDataMapper
{
    static public function mapFromScheme(array $productScheme) : Product
    {
        return new Product(
            $productScheme['product_code'],
            $productScheme['price'],
            $productScheme['product_name'],
            $productScheme['description']
        );
    }

    static public function mapToScheme(Product $product) : array
    {
        return [
            'product_code' => $product->getCode(),
            'price' => $product->getPrice(),
            'product_name' => $product->getName(),
            'description' => $product->getDescription()
        ];
    }
}