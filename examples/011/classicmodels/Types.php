<?php

class Types
{
    private static $queryType;
    private static $customerType;
    private static $employeeType;
    private static $nodeType;

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
}