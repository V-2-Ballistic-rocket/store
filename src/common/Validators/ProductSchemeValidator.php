<?php

namespace App\common\Validators;

class ProductSchemeValidator extends ProductValidator
{
    public function isValidScheme(array $data) : bool
    {
        if(!isset($data))
        {
           return false;
        }
        if(count($data) != self::CURRENT_NUMB_OF_FIELDS)
        {
            return false;
        }
        if(!$this->checkPrice($data["price"]))
        {
            return false;
        }
        if(!$this->checkProductCode($data["product_code"]))
        {
            return false;
        }
        if(!$this->checkProductName($data["product_name"]))
        {
            return false;
        }
        if(!$this->checkDescription($data["description"]))
        {
            return false;
        }
        return true;
    }
}
