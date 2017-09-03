<?php
namespace GraphQL\Client\Query;

/**
 * Class AbstractFragment
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
abstract class AbstractFragment extends AbstractQuery implements FragmentInterface
{
    /** @var  string */
    private $typeName;
    /** @var array  */
    private $fields = [];

    public function __construct($name = null, $typeName = null, array $fields = [])
    {
        parent::__construct($name);
        $this->setTypeName($typeName);
        $this->setFields($fields);
    }

    /**
     * @return string
     */
    abstract protected function getFragmentStr();

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
}