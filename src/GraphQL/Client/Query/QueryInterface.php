<?php
namespace GraphQL\Client\Query;

/**
 * Interface QueryInterface
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface QueryInterface
{
    /**
     * @param $name
     * @return mixed
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function __toString();
}