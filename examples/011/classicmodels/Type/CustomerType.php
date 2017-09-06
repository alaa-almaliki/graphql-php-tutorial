<?php

use \GraphQL\Type\Definition\Type;

class CustomerType extends \GraphQL\Type\Definition\ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Customer',
            'description' => 'Customer',
            'fields' => function() {
                return [
                    'customerNumber'=>  Type::int(),


                ];
            },
        ];
        parent::__construct($config);
    }
}