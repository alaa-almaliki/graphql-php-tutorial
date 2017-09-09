<?php
namespace GraphQL\Client\Query;

/**
 * Class Fragment
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Fragment extends AbstractFragment
{
    /**
     * @return string
     */
    protected function getFragmentStr()
    {
        return 'fragment %s on %s { %s }';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            $this->getFragmentStr(),
            $this->getName(),
            $this->getTypeName(),
            $this->getFieldString($this->getFields())
        );
    }
}