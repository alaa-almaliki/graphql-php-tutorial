<?php
namespace GraphQL\Client\Query\Field;

use GraphQL\Client\Query\AbstractQuery;
use GraphQL\Client\Query\Field\Argument\ValueResolver;

/**
 * Class Argument
 * @package GraphQL\Client\Query\Field
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Argument extends AbstractQuery implements ArgumentInterface
{
    /** @var  string */
    private $value;

    /**
     * Argument constructor.
     * @param  string|null $name
     * @param  string|null $value
     */
    public function __construct($name = null, $value = null)
    {
        parent::__construct($name);
        $this->setValue($value);
    }

    /**
     * @param int|string $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = ValueResolver::resolve($value);
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