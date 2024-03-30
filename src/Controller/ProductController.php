<?php

namespace App\Controller;

use App\common\Validators\ProductSchemeValidator;
use App\common\Validators\ProductValidator;
use App\Core\Body;
use App\Core\HttpCode;
use App\Entity\Product;
use App\Service\Product\ProductDbManager;

class ProductController implements EntityControllerInterface
{
    function __construct(
        private ProductValidator       $productValidator,
        private ProductSchemeValidator $productSchemeValidator,
        private ProductDbManager       $dbManager
    )
    {
    }

    public function getEntity(Body $body): Product
    {
        if (null === $this->dbManager->getProduct($body->getDBDTO())) {
            throw new \Exception("Not found", HttpCode::NOT_FOUND);
        }

        return $this->dbManager->getProduct($body->getDBDTO());
    }

    public function addEntity(Body $body): int
    {
        if (!$this->productSchemeValidator->isValidScheme($body->getPhpInputData())) {
            throw new \Exception("Scheme invalid", HttpCode::BAD_REQUEST);
        }

        $product = Product::createProductByAssocArr($body->getPhpInputData());

        if (!$this->productValidator->isValidProduct($product)) {
            throw new \Exception("Product invalid", HttpCode::BAD_REQUEST);
        }
        return $this->dbManager->addProduct($product, $body->getDBDTO());
    }

    public function deleteEntity(Body $body): void
    {
        $this->dbManager->deleteProduct($body->getDBDTO());
    }

    public function editEntity(Body $body): void
    {
        if (!$this->productSchemeValidator->isValidScheme($body->getPhpInputData())) {
            throw new \Exception("Scheme invalid", HttpCode::BAD_REQUEST);
        }

        $product = Product::createProductByAssocArr($body->getPhpInputData());

        if (!$this->productValidator->isValidProduct($product)) {
            throw new \Exception("Product invalid", HttpCode::BAD_REQUEST);
        }

        $this->dbManager->editProduct($product, $body->getDBDTO());
    }
}
