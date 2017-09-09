<?php
namespace GraphQL\Client\Query;

/**
 * Class AbstractQuery
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
abstract class AbstractQuery implements QueryInterface
{
    /** @var  string */
    private $name;

    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * AbstractQuery constructor.
     * @param  string $name
     */
    public function __construct($name = null)
    {
        $this->setName($name);
    }

    /**
     * @param  string $name
     * @return mixed
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
}