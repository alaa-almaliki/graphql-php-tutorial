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
            'fields' => [
                'id' => Type::id(),
                'firstName' => Type::string(),
                'lastName' => Type::string(),
                'email' => Type::string(),
                'phoneNumber' => Type::string()
            ]
        ];

        parent::__construct($config);
    }
}