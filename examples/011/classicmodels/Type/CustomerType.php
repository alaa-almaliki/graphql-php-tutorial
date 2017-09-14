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
                    'id' => [
                        'type' =>               Type::id(),
                    ],
                    'customerNumber'            => Type::int(), // copied to the  id field in the api
                    'customerName'              => Type::string(),
                    'contactLastName'           => Type::string(),
                    'contactFirstName'          => Type::string(),
                    'phone'                     => Types::string(),
                    'addressLine1'              => Type::string(),
                    'addressLine2'              => Type::string(),
                    'city'                      => Type::string(),
                    'state'                     => Type::string(),
                    'postalCode'                => Type::string(),
                    'country'                   => Type::string(),
                    'salesRepEmployeeNumber'    => Type::string(),
                    'creditLimit'               => Type::int(),
                    'payment'                   => [
                        'type' => Types::payment()
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

    public function resolvePayment(Customer $customer)
    {
        return (new Payment())->getByCustomer($customer->customerNumber);
    }
}