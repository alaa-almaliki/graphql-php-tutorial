<?php
namespace GraphQL\Client\Query;

/**
 * Class Fragment
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Fragment extends AbstractQuery implements FragmentInterface
{
    /** @var string  */
    private $fragmentStr = 'fragment %s on %s { %s }';
    /** @var  string */
    private $typeName;
    /** @var array  */
    private $fields = [];

    /**
     * @param  string $typeName
     * @return $this
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;
        return $this;
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * @param  array $fields
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param  array $fields
     * @return string
     */
    protected function getFieldString(array $fields)
    {
        $str = '';
        foreach ($fields as $field) {
            if (is_string($field)) {
                $str .= $field . ' ';
            } else if (is_array($field)) {
                $str .= sprintf('{ %s }', $this->getFieldString($field));
            }
        }

        return $str;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            $this->fragmentStr,
            $this->getName(),
            $this->getTypeName(),
            $this->getFieldString($this->getFields())
        );
    }
}