<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class UserType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'User',
            'description' => 'User',
            'fields' => function() {
                return [
                    'id' => Type::id(),
                    'email' => [
                        'type' => Type::string()
                    ],
                    'firstName' => [
                        'type' => Type::string(),
                    ],
                    'lastName' => [
                        'type' => Type::string(),
                    ],
                    'city' => [
                        'type' => Type::string(),
                    ],
                    'phoneNumber' => [
                        'type' => Type::string(),
                    ],
                    'dob' => [
                        'type' => Type::string(),
                    ],
                ];
            },
        ];
        parent::__construct($config);
    }
}