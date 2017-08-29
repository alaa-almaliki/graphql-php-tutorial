<?php
namespace GraphQL\Client\Query\Field;

use GraphQL\Client\Query\QueryInterface;

/**
 * Interface ArgumentInterface
 * @package GraphQL\Client\Query\Field
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ArgumentInterface extends QueryInterface
{
    /**
     * @param  string|int $value
     * @return mixed
     */
    public function setValue($value);

    /**
     * @return mixed
     */
    public function getValue();
}