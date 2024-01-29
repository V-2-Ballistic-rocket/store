<?php


namespace Tests\Unit;

use App\Entity\Product;
use Tests\Support\UnitTester;
use App\Service\Validator\Product\ProductValidator;





class ProductValidatorTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    protected function _before(){}
    // tests
    public function testSomeFeature(){}

    public function productProvider():array{
        return [
            'когда всё впорядке'=>[
                $product = new Product(
                    '1-23456789',
                    '450,00',
                    'RTX 4050',
                    'description'
                )],
            'когда всё впорядке 1'=> [
                $product = new Product(
                    '12-3456789',
                    '1,00',
                    'life234',
                    'description'
                )],
            'когда всё впорядке 2'=>[
                $product = new Product(
                    '123-456789',
                    '1,00',
                    'paper',
                    'description'
                )],
            'когда всё впорядке 3'=>[
                $product = new Product(
                    '1-23456789',
                    '450,00',
                    'RTX 4050',
                    'description'
                )]
        ];
    }
    /**
     * @dataProvider productProvider
     */
    public function testValidation($product){

        $validator = new ProductValidator;
        $this->tester->assertTrue($validator->isValidProduct($product));
    }

    public function productInvalidProductCodeProvider():array{
        return [
            'когда в коде продукта два минуса' => 
            [
                '1-23-456789'
            ],
            'когда в коде продукта нет минусов' => 
            [
                '1456789'
            ],
            'когда в коде продукта в коде продвца больше трёх символов' => 
            [
                '1245-6789'
            ],
            'когда в коде продукта в коде продвца нет символов' => 
            [
                '-4567899'
            ],
            'когда в коде продукта после минуса нет символов' => 
            [
                '22-'
            ],
            'когда в коде продавца есть буквы' => 
            [
                'ф22-1234'
            ],
            'когда в коде продукта есть буквы' => 
            [
                '23-23234ч'
            ],
            'когда в коде продукта и в коде продавца есть буквы' => 
            [
                'а3-23234ч'
            ],
            'когда в коде товара больше 10 символов' => 
            [
                '012-3456789'
            ]
        ];
    }
    /**
     * @dataProvider productInvalidProductCodeProvider
     */
    public function testInvalidProductCodeValidation($productCode){
        $product = new Product($productCode, '450,00', 'RTX 4050', 'description');
        $validator = new ProductValidator;
        $this->tester->assertFalse($validator->isValidProduct($product));
    }

    public function productInvalidPriceProvider():array{
        return [
            'когда в цене продукта нет символов' => 
            [
                ''
            ],
            'когда в цене продукта нет десятичной части' => 
            [
                '10'
            ],
            'когда в цене продукта нет десятичной части, но есть запятая' => 
            [
                '10,'
            ],
            'когда в цене продукта только десятичная часть' => 
            [
                ',99'
            ],
            'когда в цене продукта один знак после запятой' => 
            [
                '1,0'
            ],
            'когда в цене продукта после запятой больше двух символов' => 
            [
                '1,000'
            ],
            'когда в цене продукта есть буквы' => 
            [
                '45О,О0'
            ],
            'когда в цене продукта есть буквы (только справа от ,)' => 
            [
                '45,ф0'
            ],
            'когда в цене продукта есть буквы (только слева от ,)' => 
            [
                '45ф,70'
            ],
            'когда в цене продукта указана только запятая' => 
            [
                ','
            ],
            'когда в цене продукта указана только 2 запятых' => 
            [
                ',,'
            ],
            'когда в цене продукта 2 запятых' => 
            [
                '23,,45'
            ],
            'когда в цене продукта 2 запятых #2' => 
            [
                ',2345,'
            ],
            'когда в цене продукта указана только запятая и ноль' => 
            [
                ',0'
            ],
            'когда в цене продукта указана только запятая и буква справа' => 
            [
                ',i'
            ],
            'когда в цене продукта указана только запятая и буква слева' => 
            [
                'х,'
            ],
            'когда в цене продукта указана только запятая и ноль слева' => 
            [
                '0,'
            ],
            'когда в цене продукта указана только запятая и ноль справа и слева' => 
            [
                '0,0'
            ],
            'когда в цене продукта указано булево значение' => 
            [
                true
            ],
            'когда в цене продукта указана точка' => 
            [
                '123.456'
            ],
        ];
    }
    /**
     * @dataProvider productInvalidPriceProvider
     */
    public function testInvalidPriceValidation($price)
    {
        $product = new Product('11-1111', $price, 'RTX 4050', 'description');
        $validator = new ProductValidator;
        $this->tester->assertFalse($validator->isValidProduct($product));
    }

    public function productInvalidNameProvider():array{
        return [
            'когда в названии продукта нет символов' => 
            [
                ''
            ],
            ' когда в названии продукта меньше 5 символов' => 
            [                                      
                'life'  
            ],
            'когда в названии продукта больше 64 символов' => 
            [
                'paperpaperpaperpaperpaperpaperpaperpaperpaperpaperpaperpaper12345'
            ]
        ];
    }
     /**
     * @dataProvider productInvalidNameProvider
     */
    public function testInvalidNameValidation($productName)
    {
        $product = new Product('11-1111', '450,00', $productName, 'description');
        $validator = new ProductValidator;
        $this->tester->assertFalse($validator->isValidProduct($product));
    }

    public function productInvalidDescriptionProvider():array{
        return [
            'когда в описании продукта меньше 300 символов' => 
            [
                '_тридцать-символов--------раз_'.
                '_тридцать-символов--------два_'.
                '_тридцать-символов--------три_'.
                '_тридцать-символов-----четыре_'.
                '_тридцать-символов-------пять_'.
                '_тридцать-символов------шесть_'.
                '_тридцать-символов-------семь_'.
                '_тридцать-символов-----восемь_'.
                '_тридцать-символов-----девять_'.
                '_тридцать-символов-----десять_'.
                '1'
            ]
        ];
    }
    
     /**
     * @dataProvider productInvalidDescriptionProvider
     */
    public function testInvalidDescriptionValidation($description)
    {
        $product = new Product('11-1111', '450,00', 'RTX 4050', $description);
        $validator = new ProductValidator;
        $this->tester->assertFalse($validator->isValidProduct($product));
    }
}