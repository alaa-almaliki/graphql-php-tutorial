<?php
namespace GraphQL\Client\Query\Fragment;

use GraphQL\Client\Query\AbstractFragment;

/**
 * Class Inline
 * @package GraphQL\Client\Query\Fragment
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Inline extends AbstractFragment
{

    public function __construct($typeName = null, array $fields = [])
    {
        parent::__construct(null, $typeName, $fields);
    }

    /**
     * @return string
     */
    protected function getFragmentStr()
    {
        return '...on %s { %s }';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            $this->getFragmentStr(),
            $this->getTypeName(),
            $this->getFieldString($this->getFields())
        );
    }
}