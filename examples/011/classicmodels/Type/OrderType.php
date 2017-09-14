<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class OrderType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Order',
            'description' => 'Order',
            'fields' => function () {
                    return [
                    'id' => Type::int(),
                    'orderNumber' => Type::int(),
                    'orderDate' => Type::string(),
                    'requiredDate' => Type::string(),
                    'shippedDate' => Type::string(),
                    'status' => Type::string(),
                    'comments' => Type::string(),
                    'customerNumber' => Type::int(),
                    'customer' => [
                        'type' => Types::customer(),
                        'args' => [
                            'customerNumber' => Type::int(),
                        ]
                    ]
                ];
            },
            'resolveField' => function($value, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info) {
                $method = 'resolve' . ucfirst($info->fieldName);
                if (method_exists($this, $method)) {
                    return $this->{$method}($value, $args, $context, $info);
                } else {
                    return $value->{$info->fieldName};
                }
            }


        ];
        parent::__construct($config);
    }

    public function resolveCustomer(Order $order)
    {
        return (new Customer())->getById($order->customerNumber);
    }
}