<?php
namespace GraphQL\Client\Query;

/**
 * Class Type
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class KeyWord
{
    const KEY_WORD_QUERY      = 'query';
    const KEY_WORD_MUTATION   = 'mutation';

    /**
     * @return string
     */
    public function getQuery()
    {
        return self::KEY_WORD_QUERY;
    }

    /**
     * @return string
     */
    public function getMutation()
    {
        return self::KEY_WORD_MUTATION;
    }

    /**
     * @param  string $type
     * @return bool
     */
    public function isQuery($type)
    {
        return $type === self::KEY_WORD_QUERY;
    }

    /**
     * @param  string $type
     * @return bool
     */
    public function isMutation($type)
    {
        return $type === self::KEY_WORD_MUTATION;
    }

    /**
     * @param  string $type
     * @return bool
     */
    public function isValid($type)
    {
        return in_array($type, $this->getAvailableTypes());
    }

    /**
     * @return array
     */
    public function getAvailableTypes()
    {
        return [
            self::KEY_WORD_QUERY,
            self::KEY_WORD_MUTATION,
        ];
    }
}