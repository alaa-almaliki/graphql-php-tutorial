<?php
namespace GraphQL\Client\Query;

/**
 * Class Type
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Type
{
    const QUERY_TYPE_QUERY      = 'query';
    const QUERY_TYPE_MUTATION   = 'mutation';

    /**
     * @return string
     */
    public function getQueryType()
    {
        return self::QUERY_TYPE_QUERY;
    }

    /**
     * @return string
     */
    public function getMutationType()
    {
        return self::QUERY_TYPE_MUTATION;
    }

    /**
     * @param  string $type
     * @return bool
     */
    public function isQuery($type)
    {
        return $type === self::QUERY_TYPE_QUERY;
    }

    /**
     * @param  string $type
     * @return bool
     */
    public function isMutation($type)
    {
        return $type === self::QUERY_TYPE_MUTATION;
    }

    /**
     * @param  string $type
     * @return bool
     */
    public function isValidType($type)
    {
        return in_array($type, $this->getAvailableTypes());
    }

    /**
     * @return array
     */
    public function getAvailableTypes()
    {
        return [
            self::QUERY_TYPE_QUERY,
            self::QUERY_TYPE_MUTATION,
        ];
    }
}