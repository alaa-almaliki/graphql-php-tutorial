<?php
namespace GraphQL\Client\Query;

/**
 * Interface FragmentInterface
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface FragmentInterface extends QueryInterface
{
    /**
     * @param  string $typeName
     * @return mixed
     */
    public function setTypeName($typeName);

    /**
     * @return string
     */
    public function getTypeName();

    /**
     * @param  array $fields
     * @return mixed
     */
    public function setFields(array $fields);

    /**
     * @return array
     */
    public function getFields();
}