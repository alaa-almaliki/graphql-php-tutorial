<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductLineType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'ProductLine',
            'description' => 'ProductLine',
            'fields' => function () {
                return [
                    'productLine' => Type::string(),
                    'textDescription' => Type::string(),
                    'htmlDescription' => Type::string(),
                    'image' => Type::string()
                ];
            },
        ];
        parent::__construct($config);
    }
}