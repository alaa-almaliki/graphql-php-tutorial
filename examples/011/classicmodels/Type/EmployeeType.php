<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class EmployeeType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Employee',
            'description' => 'Employee',
            'fields' => function() {
                return [
                    'id' => [
                        'type' =>               Type::id(),
                    ],
                    'employeeNumber'            => Type::int(), // replaced with id in the api
                    'lastName'              => Type::string(),
                    'firstName'           => Type::string(),
                    'extension'          => Type::string(),
                    'email'                     => Type::string(),
                    'officeCode'              => Type::string(),
                    'reportsTo'              => Type::string(),
                    'jobTitle'                      => Type::string(),
                ];
            },
        ];
        parent::__construct($config);
    }
}