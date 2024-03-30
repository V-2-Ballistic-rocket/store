<?php

namespace App\common\Validators;

class ProductValidator 
{
    protected const CURRENT_NUMB_OF_FIELDS = 4;
    
    private const PR_CODE_MAX_LENGTH = 10;
    private const PR_CODE_MAX_SELLER_CODE = 3;
    private const PR_CODE_NUMB_OF_SEPARATORS = 1;

    private const PRICE_NUMB_OF_DECIMAL_PLACES = 2;
    private const PRICE_NUMB_OF_SPLIT = 2;
    
    private const PR_NAME_MIN_LENGTH = 5;
    private const PR_NAME_MAX_LENGTH = 64;
    
    private const DESC_MAX_LENGTH = 300;
    

    public function isValidProduct($product) : bool 
    {
        if(!$this->checkProductCode($product->getCode())){
            return false;
        }
        if(!$this->checkPrice($product->getPrice())){
            return false;
        }
        if(!$this->checkProductName($product->getName())){
            return false;
        }
        if(!$this->checkDescription($product->getDescription())){
            return false;
        }

        return true;
    }

    protected function checkProductCode(string $productCode) : bool 
    {
        if(is_null($productCode)){
            return false;
        }

        if(strlen($productCode) > self::PR_CODE_MAX_LENGTH){
            return false;
        }

        if((stripos($productCode, "-",0) > self::PR_CODE_MAX_SELLER_CODE) 
        || (stripos($productCode, "-",0) === false)){
            return false;
        }

        if(substr_count($productCode, "-") != self::PR_CODE_NUMB_OF_SEPARATORS){
            return false;
        }

        $productCode_arr = explode("-", $productCode);
        foreach($productCode_arr as $value){
            if(!is_numeric($value)){
                return false;
            }
        }
        
        return true;
    }

    protected function checkPrice(string $price) : bool {
        if(is_null($price)){
            return false;
        }

        $priceArr = explode(",", $price);
        if(count($priceArr) != self::PRICE_NUMB_OF_SPLIT){
            return false;
        }

        //проверка на буквы в переменной
        foreach($priceArr as $value){
            if(!is_numeric($value)){
                return false;
            }
        }
 
        //проверка на то, что после запятой 2 символа
        //берем вторую часть из разделенной запятой цены и смотрим сколько знаков после запятой
        if(iconv_strlen($priceArr[1]) != self::PRICE_NUMB_OF_DECIMAL_PLACES){
            return false;          
        }

        return true;
    }

    protected function checkProductName(string $productName) : bool {
        if(is_null($productName)){
            return false;
        }
        //проверка на количество символов (от 5 до 64)
        if(iconv_strlen($productName) < self::PR_NAME_MIN_LENGTH 
        || iconv_strlen($productName) > self::PR_NAME_MAX_LENGTH){
            return false;
        }
        
        return true;
    }

    protected function checkDescription(string $description) : bool {
        if(is_null($description)){
            return false;
        }
        //проверка на количество символов (от 300 символов)
        if(iconv_strlen($description) > self::DESC_MAX_LENGTH){
            return false;
        }

        return true;
    }
}