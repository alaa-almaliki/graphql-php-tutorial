<?php

class Types
{
    private static $queryType;
    private static $customerType;

    static public function customer()
    {
        return self::$customerType ? : (self::$customerType = new CustomerType());
    }

    static public function query()
    {
        return self::$queryType ? : (self::$queryType = new QueryType());
    }
}