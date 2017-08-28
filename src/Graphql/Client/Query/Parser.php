<?php
namespace GraphQL\Client\Query;

class Parser
{
    const QUERY_TYPE_QUERY = 'query';
    const QUERY_TYPE_MUTATION = 'mutation';

    private $queryString = '{"query": "%s { %s }"}';
    private $type;
    private $field;

    public function __construct(Field $field = null, $type = self::QUERY_TYPE_QUERY)
    {
        $this->field = $field;
        $this->type = $type;
    }

    public function setField(Field $field): Parser
    {
        $this->field = $field;
        return $this;
    }

    public function getField() : Field
    {
        return $this->field;
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
        return sprintf($this->queryString, $this->getType(), $this->getField());
    }
}