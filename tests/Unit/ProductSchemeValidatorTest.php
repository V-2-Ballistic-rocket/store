<?php


namespace Tests\Unit;

use Tests\Support\UnitTester;
use App\Service\Validator\Product\ProductSchemeValidator;

class ProductSchemeValidatorTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    public function productProvider1(): array
    {
        return [
            'когда всё нормально' => 
            [[
                'product_code' => '1-23456789',
                'price' => '450,00',
                'product_name' => 'RTX 4050',
                'description' => 'description'
            ]]
        ];
    }

    /**
     * @dataProvider productProvider1
     */
    public function testValidation(array $productScheme)
    {
        $validator = new ProductSchemeValidator;
        $this->tester->assertTrue($validator->isValidScheme($productScheme));
        
    }
    public function productInvalidProductCodeProvider(): array
    {
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
    public function testInvalidProductCodeValidation($productCode)
    {
        $productSheme = [
            'product_code' => $productCode,
            'price' => '450,00',
            'product_name' => 'RTX 4050',
            'description' => 'description'
        ];
        $validator = new ProductSchemeValidator;
        $this->tester->assertFalse($validator->isValidScheme($productSheme));
    }

    public function productInvalidPriceProvider(): array
    {
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
        $productScheme = 
        [
            'product_code' => '11-1111',
            'price' => $price,
            'product_name' => 'RTX 4050',
            'description' => 'description'
        ];
        $validator = new ProductSchemeValidator;
        $this->tester->assertFalse($validator->isValidScheme($productScheme));
    }

    public function productInvalidNameProvider(): array
    {
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
    public function testInvalidNameValidation($product_name)
    {
        $productScheme = [
            'product_code' => '1-23456789',
            'price' => '450,00',
            'product_name' => $product_name,
            'description' => 'description'
        ];
        $validator = new ProductSchemeValidator;
        $this->tester->assertFalse($validator->isValidScheme($productScheme));
    }

    public function productInvalidDescriptionProvider(): array
    {
        return [
            'когда в описании продукта меньше 300 символов' => 
            [
                '_тридцать-символов--------раз_' .
                '_тридцать-символов--------два_' .
                '_тридцать-символов--------три_' .
                '_тридцать-символов-----четыре_' .
                '_тридцать-символов-------пять_' .
                '_тридцать-символов------шесть_' .
                '_тридцать-символов-------семь_' .
                '_тридцать-символов-----восемь_' .
                '_тридцать-символов-----девять_' .
                '_тридцать-символов-----десять_' .
                '1'
            ]
        ];
    }

    /**
     * @dataProvider productInvalidDescriptionProvider
     */
    public function testInvalidDescriptionValidation($description)
    {
        $productScheme = [
            'product_code' => '123-456789',   
            'price' => '1,00',
            'product_name' => 'data name',
            'description' => $description
        ];
        $validator = new ProductSchemeValidator;
        $this->tester->assertFalse($validator->isValidScheme($productScheme));
    }

    public function productEmptyDataProvider(): array
    {
        return [
            'когда нет полей' => [
                [
                    
                ]
            ],
            'когда не все поля есть' => [
                [
                    'product_code' => '1-23456789',
                    'price' => '450,00',
                    'product_name' => 'RTX 4050'
                ]
            ],
            'когда есть лишнее поле' => [
                [
                    'product_code' => '1-23456789',
                    'price' => '450,00',
                    'product_name' => 'RTX 4050',
                    'description' => 'description',
                    'descript234ion' => 'descr423iption'
                ]
            ],
            'когда значения полей пустые' => [
                [
                    'product_code' => '',
                    'price' => '',
                    'product_name' => '',
                    'description' => ''
                ]
            ],
        ];
    }

    /**
     * @dataProvider productEmptyDataProvider
     */
    public function testEmptyData($data)
    {
        $validator = new ProductSchemeValidator;
        $this->tester->assertFalse($validator->isValidScheme($data));
    }
}
