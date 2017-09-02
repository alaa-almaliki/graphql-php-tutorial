<?php
namespace GraphQL\Client\Query\Field\Argument;

/**
 * Class ValueResolver
 * @package GraphQL\Client\Query\Field\Argument
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ValueResolver
{
    /**
     * @param  string $value
     * @return bool
     */
    static public function isVariable($value)
    {
        return strpos($value, '$') !== false;
    }

    /**
     * @param  string $value
     * @return bool
     */
    public function isLiteral($value)
    {
        return !static::isVariable($value);
    }

    /**
     * @param  string $value
     * @return string
     */
    static public function resolve($value)
    {
        if (static::isVariable($value)) {
            return $value;
        }

        return json_encode($value);
    }
}