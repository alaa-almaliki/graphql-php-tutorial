<?php
namespace GraphQL\Client\Query;

class Parser
{
    const QUERY_TYPE_QUERY = 'query';
    const QUERY_TYPE_MUTATION = 'mutation';

    private $queryString = '{"query": "%s { %s }"}';
    private $type;
    private $fields = [];

    public function __construct(array $fields = [], $type = self::QUERY_TYPE_QUERY)
    {
        $this->setFields($fields);
        $this->type = $type;
    }

    public function addNewField($name, array $arguments = [])
    {
        $field = new Field($name);
        foreach ($arguments as $argName => $argValue) {
            $this->_addArgumentToField($field, $argName, $argValue);
        }

        return $this->addFieldObject($field);
    }

    public function addArgumentsToField($name, array $arguments = [])
    {
        $field = $this->getField($name);
        foreach ($arguments as $argName => $argValue) {
            $this->_addArgumentToField($field, $argName, $argValue);
        }

        return $this;
    }

    public function addArgumentToField($name, $argName, $argValue)
    {
        if (empty($argName) || empty($argValue)) {
            throw new QueryException('Argument has no name or value.');
        }
        $this->_addArgumentToField($this->getField($name), $argName, $argValue);
        return $this;
    }

    protected function _addArgumentToField(FieldInterface $field, $argName, $argValue)
    {
        $field->addArgument($argName, $argValue);
        return $this;
    }

    /**
     * @param $name
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
    public function addFieldObject(FieldInterface $field) : Parser
    {
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    public function addFields(array $fields = [])
    {
        foreach ($fields as $field) {
            $args = isset($field['args']) ? $field['args'] : [];
            $this->addNewField($field['name'], $args);
        }
    }

    public function setFields(array $fields): Parser
    {
        foreach ($fields as $field) {
            $this->addFieldObject($field);
        }

        return $this;
    }

    public function getFields() : array
    {
        return $this->fields;
    }

    public function setType($type) : Parser
    {
        $this->type = $type;
        return $this;
    }

    public function getType() : string
    {
        return $this->type;
    }

    public function parse($print = false)
    {
        $query =  sprintf($this->queryString, $this->getType(), implode(', ', $this->getFields()));
        if ($print) {
            print_r($query);
        }

        return $query;
    }
}