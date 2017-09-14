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
    private static $orderType;
    private static $orderDetailsType;
    private static $payment;

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

    static public function order()
    {
        return self::$orderType?: (self::$orderType = new OrderType());
    }

    static public function payment()
    {
        return self::$payment?: (self::$payment = new PaymentType());
    }

    static public function email()
    {
        return Registry::basicEmailType();
    }

    static public function phoneNumber()
    {
        return Registry::phoneNumberType('GB');
    }

    static public function orderDetails()
    {
        return self::$orderDetailsType?: (self::$orderDetailsType = new OrderDetailsType());
    }

    static public function string()
    {
        return Type::string();
    }

    static public function int()
    {
        return Type::int();
    }

    static public function float()
    {
        return Type::float();
    }

    static public function id()
    {
        return Type::id();
    }
}