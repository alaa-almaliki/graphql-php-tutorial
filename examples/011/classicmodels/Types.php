<?php

use GraphQL\Custom\Scalar\Types\Registry;
use GraphQL\Type\Definition\Type;
class Types
{
    private static $queryType;
    private static $customerType;
    private static $employeeType;
    private static $nodeType;
    private static $office;

    static public function customer()
    {
        return self::$customerType ? : (self::$customerType = new CustomerType());
    }

    static public function employee()
    {
        return self::$employeeType ? : (self::$employeeType = new EmployeeType());
    }

    static public function node()
    {
        return self::$nodeType ? : (self::$nodeType = new NodeType());
    }

    static public function query()
    {
        return self::$queryType ? : (self::$queryType = new QueryType());
    }

    static public function office()
    {
        return self::$office ?: (self::$office = new OfficeType());
    }

    static public function email()
    {
        return Registry::basicEmailType();
    }

    static public function phoneNumber()
    {
        return Registry::phoneNumberType('GB');
    }

    static public function string()
    {
        return Type::string();
    }
}