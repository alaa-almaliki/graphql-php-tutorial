<?php
namespace GraphQL\Client\Query;

use GraphQL\Client\Query\Field\Argument;

class Field
{
    /** @var  string */
    private $name;
    /** @var array  */
    private $arguments = [];
    /** @var array  */
    private $fields = [];

    public function __construct($name = null, array $arguments = [])
    {
        $this->name = $name;
        $this->setArguments($arguments);
    }

    public function setName($name) : Field
    {
        $this->name = $name;
        return $this;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setArguments(array $arguments = []) : Field
    {
        foreach ($arguments as $argument) {
            $this->addArgument($argument);
        }
        return $this;
    }

    public function getArguments() : array
    {
        return $this->arguments;
    }

    public function addArgument($name, $value) : Field
    {
        return $this->addArgumentObject(new Argument($name, $value));
    }

    public function addArgumentObject(Argument $argument) : Field
    {
        $this->arguments[$argument->getName()] = $argument;
        return $this;
    }

    public function removeArgument(Argument $argument) : Field
    {
        unset($this->arguments[$argument->getName()]);
        return $this;
    }

    public function hasArguments()
    {
        return $this->getArgumentsCount() > 0;
    }

    public function getArgumentsCount()
    {
        return count($this->getArguments());
    }

    public function addField(Field $field) : Field
    {
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    public function removeField(Field $field)
    {
        unset($this->fields[$field->getName()]);
        return $this;
    }

    public function getFields() : array
    {
        return $this->fields;
    }

    public function hasFields() : bool
    {
        return $this->getFieldsCount() > 0;
    }

    public function getFieldsCount(): int
    {
        return count($this->getFields());
    }

    public function getFieldString() : string
    {
        $str = $this->getName();
        if ($this->hasArguments()) {
            $str = $this->getName() . '( %s )';
        }
        return sprintf($str, implode(', ', $this->getArguments()));
    }

    public function __toString() : string
    {
        $toString = $this->getFieldString();
        $fieldsString = '{ %s }';
        /** @var Field $field */
        foreach ($this->getFields() as $field) {
            $toString .= sprintf($fieldsString, $field->getFieldString());
        }
        return $toString;
    }
}