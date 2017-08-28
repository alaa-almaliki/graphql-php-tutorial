<?php
namespace GraphQL\Client\Query;

class Argument
{
    /** @var  string */
    private $name;
    /** @var  string */
    private $value;

    public function __construct($name = null, $value = null)
    {
        $this->setName($name);
        $this->value    = $value;
    }

    public function setName($name) : Argument
    {
        $this->name = $name;
        return $this;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setValue($value) : Argument
    {
        $this->value = $value;
        return $this;
    }

    public function getValue() : string
    {
        return $this->value;
    }

    public function __toString() : string
    {
        return $this->getName() . ': ' . $this->getValue();
    }
}