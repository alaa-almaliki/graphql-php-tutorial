<?php
namespace GraphQL\Client\Query;

use GraphQL\Client\Query\Field\Argument;
use GraphQL\Client\Query\Field\ArgumentInterface;

/**
 * Class Field
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Field implements FieldInterface
{
    /** @var  string */
    private $name;
    /** @var array  */
    private $arguments = [];
    /** @var array  */
    private $fields = [];

    /**
     * Field constructor.
     * @param string|null $name
     * @param array $arguments
     */
    public function __construct($name = null, array $arguments = [])
    {
        $this->name = $name;
        $this->setArguments($arguments);
    }

    /**
     * @param  string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  array $arguments
     * @return $this
     */
    public function setArguments(array $arguments = [])
    {
        foreach ($arguments as $argument) {
            $this->addArgumentObject($argument);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param  string $name
     * @param  string $value
     * @return $this
     */
    public function addArgument($name, $value)
    {
        return $this->addArgumentObject(new Argument($name, $value));
    }

    /**
     * @param  ArgumentInterface $argument
     * @return $this
     */
    public function addArgumentObject(ArgumentInterface $argument)
    {
        $this->arguments[$argument->getName()] = $argument;
        return $this;
    }

    /**
     * @param  ArgumentInterface $argument
     * @return $this
     */
    public function removeArgument(ArgumentInterface $argument)
    {
        unset($this->arguments[$argument->getName()]);
        return $this;
    }

    /**
     * @return bool
     */
    public function hasArguments()
    {
        return $this->getArgumentsCount() > 0;
    }

    /**
     * @return int
     */
    public function getArgumentsCount()
    {
        return count($this->getArguments());
    }

    /**
     * @param  FieldInterface $field
     * @return $this
     */
    public function addField(FieldInterface $field)
    {
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    /**
     * @param  FieldInterface $field
     * @return $this
     */
    public function removeField(FieldInterface $field)
    {
        unset($this->fields[$field->getName()]);
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
     * @return bool
     */
    public function hasFields()
    {
        return $this->getFieldsCount() > 0;
    }

    /**
     * @return int
     */
    public function getFieldsCount()
    {
        return count($this->getFields());
    }

    /**
     * @return string
     */
    public function getFieldString()
    {
        $str = $this->getName();
        if ($this->hasArguments()) {
            $str = $this->getName() . '( %s )';
        }
        return sprintf($str, implode(', ', $this->getArguments()));
    }

    /**
     * @return string
     */
    public function __toString()
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