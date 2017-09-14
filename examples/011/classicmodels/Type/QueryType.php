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
                    'description' => 'Returns customer',
                    'args' => [
                        'id' => Type::nonNull(Type::int())
                    ]
                ],
                'employee' => [
                    'type' => Types::employee(),
                    'description' => 'Returns customer',
                    'args' => [
                        'id' => Type::nonNull(Type::int())
                    ]
                ],
                'order' => [
                    'type' => Types::order(),
                    'args' => [
                        'id' => Type::nonNull(Type::int())
                    ]
                ]
            ],
            'resolveField' => function($val, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info) {
                return $this->{$info->fieldName}($val, $args, $context, $info);
            }

        ];
        parent::__construct($config);
    }

    public function customer($root, $args)
    {
        return (new Customer())->getById($args['id']);
    }

    public function employee($root, $args)
    {
        return (new Employee())->getById($args['id']);
    }

    public function order($root, $args)
    {
        return (new Order())->getById($args['id']);
    }

}