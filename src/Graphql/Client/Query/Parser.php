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

    public function addField(Field $field) : Parser
    {
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    public function addFields(array $fields) : Parser
    {
        foreach ($fields as $field) {
            $this->addField($field);
        }

        return $this;
    }

    public function setFields(array $fields): Parser
    {
        foreach ($fields as $field) {
            $this->addField($field);
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

    public function parse()
    {
        return sprintf($this->queryString, $this->getType(), implode(', ', $this->getFields()));
    }
}