<?php
namespace GraphQL\Client\Query\Field;

use GraphQL\Client\Query\QueryInterface;

interface ArgumentInterface extends QueryInterface
{
    public function setValue($value);

    public function getValue();
}