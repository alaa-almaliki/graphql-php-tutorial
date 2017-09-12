<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OfficeType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Office',
            'description' => 'Office',
            'fields' => function() {
                return [
                    'id' => [
                        'type' =>               Type::id(),
                    ],
                    'officeCode'    => Type::int(),
                    'city'            => Types::string(), // replaced with id in the api
                    'phone'              => Types::string(),
                    'addressLine1'           => Types::string(),
                    'addressLine2'          => Type::string(),
                    'state'                     => Types::string(),
                    'country'              => Type::string(),
                    'postalCode'              => Type::string(),
                    'territory'                      => Type::string(),
                ];
            },
        ];
        parent::__construct($config);
    }
}