<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Product',
            'description' => 'Product',
            'fields' => [
                'productCode' => Type::string(),
                'productLine' => Type::string(),
                'productScale' => Type::string(),
                'productVendor' => Type::string(),
                'productDescription' => type::string(),
                'quantityInStock' => Type::int(),
                'buyPrice' => Type::float(),
                'MSRP' => Type::float(),
            ]
        ];
        parent::__construct($config);
    }
}