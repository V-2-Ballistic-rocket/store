<?php


namespace Tests\Unit;

use App\Service\DBDTO;
use App\Entity\Product;
use Tests\Support\UnitTester;
use App\Service\ProductDBManager;

class ProductDBManagerTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;
    public function invalidIdProvider():array
    {
        return [
            'when the id does not exist' => [
                'id' => 0
            ],
            'when the id = 0' => [
                'id' => 0
            ],
            'when id is negative' =>[
                'id' => -1
            ]
        ];
    }

    /**
     * @dataProvider invalidIdProvider
     */
    public function testInvalidId(int $id)
    {
        $productDBmanager = new ProductDBManager();
        $dto = new DBDTO('pgsql','database','app','postgres','postgres','public/database.sql', $id);
        $result = $productDBmanager->getProduct($dto);
        $this->tester->assertNull($result);
    }

    public function validIdProvider():array
    {
        return [
            'when the id is exist' => [
                'id' => 1
            ]
        ];
    }

    /**
     * @dataProvider validIdProvider
     */
    public function testValidId(int $id)
    {
        $productDBmanager = new ProductDBManager();
        $dto = new DBDTO('pgsql','database','app','postgres','postgres','public/database.sql', $id);
        $expectedResult = $productDBmanager->getProduct($dto);
        $actualResult = array('123-456', '11,11', 'product name 1', 'description 1');
        $this->tester->assertEquals($expectedResult->getArray(), $actualResult);
    }

    public function testAddProduct(){
        $productDBmanager = new ProductDBManager();
        $dto = new DBDTO('pgsql','database','app','postgres','postgres','public/database.sql', 0);

        $product = new Product('000-000', '100,00', '0000000', 'description 0000');
        $id = $productDBmanager->addProduct($product, $dto);
        
        $dto = new DBDTO('pgsql','database','app','postgres','postgres','public/database.sql', $id);
        $result = $productDBmanager->getProduct($dto);

        $this->tester->assertEquals($product->getArray(), $result->getArray());

        $productDBmanager->deleteProduct($dto);
    }

    public function testEditProduct(){
        $productDBmanager = new ProductDBManager();
        $dto = new DBDTO('pgsql','database','app','postgres','postgres','public/database.sql', 0);

        $product = new Product('000-000', '100,00', '0000000', 'description 0000');
        $id = $productDBmanager->addProduct($product, $dto);
        
        $dto = new DBDTO('pgsql','database','app','postgres','postgres','public/database.sql', $id);
        $product = new Product('77-7777', '7,77', '777777', 'description 7777777');
        $productDBmanager->editProduct($product, $dto);
        $result = $productDBmanager->getProduct($dto);

        $this->tester->assertEquals($product->getArray(), $result->getArray());

        $productDBmanager->deleteProduct($dto);
    }

    public function testDeleteProduct(){
        $productDBmanager = new ProductDBManager();
        $dto = new DBDTO('pgsql','database','app','postgres','postgres','public/database.sql', 0);

        $product = new Product('000-000', '100,00', '0000000', 'description 0000');
        $id = $productDBmanager->addProduct($product, $dto);
        
        $dto = new DBDTO('pgsql','database','app','postgres','postgres','public/database.sql', $id);
        $productDBmanager->deleteProduct($dto);

        $this->tester->assertNull($productDBmanager->getProduct($dto));

        $productDBmanager->deleteProduct($dto);
    }

    public function testGetProduct()
    {
        $productDBmanager = new ProductDBManager();
        $dto = new DBDTO('pgsql','database','app','postgres','postgres','public/database.sql', 1);

        $expectedResult = $productDBmanager->getProduct($dto);
        
        $actualResult = array('123-456', '11,11', 'product name 1', 'description 1');
        $this->tester->assertEquals($expectedResult->getArray(), $actualResult);
    }
}
