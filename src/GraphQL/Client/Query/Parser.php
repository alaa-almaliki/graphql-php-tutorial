<?php
namespace GraphQL\Client\Query;

/**
 * Class Parser
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Parser
{
    const QUERY_TYPE_QUERY = 'query';
    const QUERY_TYPE_MUTATION = 'mutation';

    /** @var string  */
    private $queryString = '{"query": "%s { %s }"}';
    /** @var string  */
    private $type;
    /** @var array  */
    private $fields = [];

    /**
     * Parser constructor.
     * @param array $fields
     * @param string $type
     */
    public function __construct(array $fields = [], $type = self::QUERY_TYPE_QUERY)
    {
        $this->setFields($fields);
        $this->type = $type;
    }

    /**
     * @param  string $name
     * @param  array $arguments
     * @param  string|null $aliasName
     * @return Parser
     */
    public function addNewField($name, array $arguments = [], $aliasName = null)
    {
        $field = new Field($name);
        $field->setAliasName($aliasName);
        foreach ($arguments as $argName => $argValue) {
            $this->_addArgumentToField($field, $argName, $argValue);
        }

        return $this->addFieldObject($field);
    }

    /**
     * @param  string $name
     * @param  array $arguments
     * @return $this
     */
    public function addArgumentsToField($name, array $arguments = [])
    {
        $field = $this->getField($name);
        foreach ($arguments as $argName => $argValue) {
            $this->_addArgumentToField($field, $argName, $argValue);
        }

        return $this;
    }

    /**
     * @param  string $name
     * @param  string $argName
     * @param  string|int|mixed $argValue
     * @return $this
     * @throws QueryException
     */
    public function addArgumentToField($name, $argName, $argValue)
    {
        if (empty($argName) || empty($argValue)) {
            throw new QueryException('Argument has no name or value.');
        }
        $this->_addArgumentToField($this->getField($name), $argName, $argValue);
        return $this;
    }

    /**
     * @param  FieldInterface $field
     * @param  string $argName
     * @param  string|int|mixed $argValue
     * @param  string|null $aliasName
     * @return $this
     */
    protected function _addArgumentToField(FieldInterface $field, $argName, $argValue, $aliasName = null)
    {
        $field->addArgument($argName, $argValue);
        if ($aliasName !== null) {
            $field->setAliasName($aliasName);
        }
        return $this;
    }

    /**
     * @param  string $name
     * @return FieldInterface
     * @throws QueryException
     */
    public function getField($name)
    {
        if (!isset($this->fields[$name])) {
            throw new QueryException('There is no field with name: ' . $name);
        }

        return $this->fields[$name];
    }

    /**
     * @param  FieldInterface $field
     * @return Parser
     */
    public function addFieldObject(FieldInterface $field)
    {
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    /**
     * @param  array $fields
     * @return $this
     */
    public function addFields(array $fields = [])
    {
        foreach ($fields as $field) {
            $aliasName = isset($field['alias_name']) ? $field['alias_name'] : null;
            $args = isset($field['args']) ? $field['args'] : [];
            $this->addNewField($field['name'], $args, $aliasName);
        }
        return $this;
    }

    /**
     * @param  array $fields
     * @return Parser
     */
    public function setFields(array $fields)
    {
        foreach ($fields as $field) {
            $this->addFieldObject($field);
        }

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
     * @param  string $type
     * @return Parser
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param  bool $print
     * @return string
     */
    public function parse($print = false)
    {
        $query =  sprintf($this->queryString, $this->getType(), implode(', ', $this->getFields()));

        if ($print) {
            print_r($query);
        }

        return $query;
    }
}