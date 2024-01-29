<?php


namespace Tests\Unit;

use Tests\Support\UnitTester;



class DBManagerTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;


    protected function _before()
    {
        // $this->db = new ProductDBManager(
        //     'public/database.sql',
        //     'pgsql',
        //     'database',
        //     'app',
        //     'postgres',
        //     'postgres'
        // );
    }

    // tests
    public function test()
    {

    }
}

//     public function validProductIdProvider():array
//     {
//         return [
//             'when id is exist' => [
//                 'id' => 1
//             ]
//         ];
//     }

//     /**
//      * @dataProvider validProductIdProvider
//      * @test
//      */
//     public function productIdIsValid($id)
//     {
//         // $product = new Product('123-456', '34,34', 'name product 1', 'description 1');
//         // $this->tester->assertTrue($this->db->editProduct($id, $product));
//         // $this->tester->assertNotFalse($this->db->getProduct($id)); //если id нет в бд, метот вернет false
//         // $this->tester->assertTrue($this->db->deleteProduct($id));
//     }

//     public function invalidProductIdProvider():array
//     {
//         return [
//             'when id is not exist' => [
//                 'id' => 2
//             ]
//         ];
//     }
//     /**
//      * @dataProvider invalidProductIdProvider
//      * @test
//      */
//     public function productidIsInvalid($id)
//     {
//         // $product = new Product('123-456', '34,34', 'name product 1', 'description 1');
//         // $this->tester->assertFalse($this->db->editProduct($id, $product));
//         // $this->tester->assertFalse($this->db->getProduct($id)); //если id нет в бд, метот вернет false
//         // $this->tester->assertFalse($this->db->deleteProduct($id));
//     }
    
//     /**
//      * @test
//      */
//     public function deleteProduct()
//     {
//         // $product = new Product('123-456', '11,11', 'product name 1', 'description 1');
//         // $id = $this->db->addProduct($product);
//         // $this->db->deleteProduct($id);
//         // $this->tester->assertFalse($this->db->getProduct($id));
//     }

//     /**
//      * @test
//      */
//     public function addProduct(){
//         // $product = new Product('123-456', '11,11', 'product name 1', 'description 1');
//         // $id = $this->db->addProduct($product);
//         // $this->tester->assertNotFalse($this->db->getProduct($id));
//     }

    
//     /**
//      * @test
//      */
//     public function editProduct()
//     {
//         // $product = new Product('123-456', '11,11', 'product name 1', 'description 1');
//         // $id = $this->db->addProduct($product);
//         // foreach($this->db->getProduct($id) as $value)
//         // {
//         //     $result1 = $value;
//         //     break;
//         // }
//         // $product = new Product('321-654', '22,22', 'product name 2', 'description 2');
//         // $this->db->editProduct($id, $product);
//         // foreach($this->db->getProduct($id) as $value)
//         // {
//         //     $result2 = $value;
//         //     break;
//         // }

//         // $this->tester->assertNotEquals($result2, $result1);
//     }

//     public function validGetProductIdProvider():array
//     {
//         return [
//             'when id is exist' => [
//                 'id' => 1
//             ]
//         ];
//     }

//     /**
//      * @dataProvider validGetProductIdProvider
//      * @test
//      */
//     public function getProduct($id)
//     {
//         // foreach($this->db->getProduct($id) as $value)
//         // {
//         //     $result = $value;
//         //     break;
//         // }
//         // $this->tester->assertEquals($result[0], '123-456');
//         // $this->tester->assertEquals($result[1], '11,11');
//         // $this->tester->assertEquals($result[2], 'product name 1');
//         // $this->tester->assertEquals($result[3], 'description 1');
//     }

// //-----------------------------------------------------------------------------------------------

// public function validUserIdProvider():array
//     {
//         return [
//             'when id is exist' => [
//                 'id' => 1
//             ]
//         ];
//     }

//     /**
//      * @dataProvider validUserIdProvider
//      * @test
//      */
//     public function userIdIsValid($id)
//     {
//         // $user = new User('login', '012345678910', '123465798');
//         // $this->tester->assertTrue($this->db->editUser($id, $user));
//         // $this->tester->assertNotFalse($this->db->getUser($id)); //если id нет в бд, метот вернет false
//         // $this->tester->assertTrue($this->db->deleteUser($id));
//     }

//     public function invalidUserIdProvider():array
//     {
//         return [
//             'when id is not exist' => [
//                 'id' => 2
//             ]
//         ];
//     }
//     /**
//      * @dataProvider invalidUserIdProvider
//      * @test
//      */
//     public function userIdIsInvalid($id)
//     {
//         // $user = new User('login', '012345678910', '123465798');
//         // $this->tester->assertFalse($this->db->editUser($id, $user));
//         // $this->tester->assertFalse($this->db->getUser($id)); //если id нет в бд, метот вернет false
//         // $this->tester->assertFalse($this->db->deleteUser($id));
//     }
    
//     /**
//      * @test
//      */
//     public function deleteUser()
//     {
//         // $user = new User('login', '012345678910', '123465798');
//         // $id = $this->db->addUser($user);
//         // $this->db->deleteUser($id);
//         // $this->tester->assertFalse($this->db->getUser($id));
//     }

//     /**
//      * @test
//      */
//     public function addUser(){
//         // $user = new User('login', '012345678910', '123465798');
//         // $id = $this->db->addUser($user);
//         // $this->tester->assertNotFalse($this->db->getUser($id));
//         // $this->db->deleteUser($id);
//     }

    
//     /**
//      * @test
//      */
//     public function editUser()
//     {
//         // $user = new User('login', '01234567891', '123465798');
//         // $id = $this->db->addUser($user);
//         // foreach($this->db->getUser($id) as $value)
//         // {
//         //     $result1 = $value;
//         //     break;
//         // }
//         // $user = new User('login 2', '10987654321', '987654321');
//         // $this->db->editUser($id, $user);
//         // foreach($this->db->getUser($id) as $value)
//         // {
//         //     $result2 = $value;
//         //     break;
//         // }
//         // $this->db->deleteUser($id);
//         // $this->tester->assertNotEquals($result2, $result1);

//     }

//     public function validGetUserIdProvider():array
//     {
//         return [
//             'when id is exist' => [
//                 'id' => 1
//             ]
//         ];
//     }

//     /**
//      * @dataProvider validGetUserIdProvider
//      * @test
//      */
//     public function getUser($id)
//     {
//         // foreach($this->db->getUser($id) as $value)
//         // {
//         //     $result = $value;
//         //     break;
//         // }
//         // $this->tester->assertEquals('login 1', $result[0]);
//         // $this->tester->assertEquals($result[1], '012345678910');
//         // $this->tester->assertEquals($result[2], '123456789');
//     }

// }
