<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderDetailsType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'OrderDetails',
            'description' => 'OrderDetail',
            'fields' => function () {
                return [
                  'id' => Type::int(),
                  'orderNumber' => Type::int(),
                  'productCode' => Type::string(),
                  'quantityOrdered' => Type::int(),
                  'priceEach' => Type::float(),
                  'orderLineNumber' => Type::int(),
                ];
            }
        ];
        parent::__construct($config);
    }
}