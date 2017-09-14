<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class PaymentType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Payment',
            'description' => 'Payment',
            'fields' => function () {
                return [
                    'customerNumber' => Type::int(),
                    'checkNumber' => Type::string(),
                    'paymentDate' => Type::string(),
                    'amount' => Type::float(),
                ];
            }
        ];
        parent::__construct($config);
    }
}