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
                    'email'                     => Types::string(),
                    'officeCode'              => Type::string(),
                    'reportsTo'              => Type::string(),
                    'jobTitle'                      => Type::string(),
                    'office'            => [
                        'type'  => Types::office(),
                        'args' => [
                            'officeCode' => Type::int()
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

    public function resolveOffice(Employee $employee)
    {
        return (new Office())->getById($employee->officeCode);
    }
}