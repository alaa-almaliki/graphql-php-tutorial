<?php
namespace GraphQL\Client\Query\Field;

/**
 * Class Argument
 * @package GraphQL\Client\Query\Field
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Argument implements ArgumentInterface
{
    /** @var  string */
    private $name;
    /** @var  string */
    private $value;

    /**
     * Argument constructor.
     * @param  string|null $name
     * @param  string|null $value
     */
    public function __construct($name = null, $value = null)
    {
        $this->setName($name);
        $this->setValue($value);
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
     * copied from stackoverflow
     * @link https://stackoverflow.com/questions/1048487/phps-json-encode-does-not-escape-all-json-control-characters/3615890#3615890
     * @param int|string $value
     * @return $this
     */
    public function setValue($value)
    {
        $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
        $this->value = str_replace($escapers, $replacements, json_encode($value));
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName() . ': ' . $this->getValue();
    }
}