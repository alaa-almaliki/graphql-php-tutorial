<?php
namespace GraphQL\Client\Query\Field;

class Argument implements ArgumentInterface
{
    /** @var  string */
    private $name;
    /** @var  string */
    private $value;

    public function __construct($name = null, $value = null)
    {
        $this->setName($name);
        $this->setValue($value);
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

    /**
     * @link https://stackoverflow.com/questions/1048487/phps-json-encode-does-not-escape-all-json-control-characters/3615890#3615890
     */
    public function setValue($value) : Argument
    {
        $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
        $this->value = str_replace($escapers, $replacements, json_encode($value));
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