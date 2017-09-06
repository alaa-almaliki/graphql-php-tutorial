<?php
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'description' => 'Query',
            'fields' => [
                'customer' => [
                    'type' => Types::customer(),
                    'description' => 'Returns user by id (in range of 1-5)',
                    'args' => [
                        'customerNumber' => Type::nonNull(Type::int())
                    ]
                ],
            ],
            'resolveField' => function($val, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info) {
                return $this->{$info->fieldName}($val, $args, $context, $info);
            }

        ];
        parent::__construct($config);
    }

    public function customer($root, $args)
    {
        return (new Customer())->getById($args['customerNumber']);
    }
}