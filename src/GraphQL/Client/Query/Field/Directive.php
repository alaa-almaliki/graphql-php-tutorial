<?php
namespace GraphQL\Client\Query\Field;

use GraphQL\Client\Query\QueryException;

/**
 * Class Directive
 * @package GraphQL\Client\Query\Field
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Directive
{
    const DIRECTIVE_INCLUDE     = 'include';
    const DIRECTIVE_SKIP        = 'skip';

    /** @var  string */
    private $directive;
    /** @var  string */
    private $operation;

    public function __construct($directive, $operation)
    {
        $this->setDirective($directive);
        $this->setOperation($operation);
    }

    /**
     * @param  string $directive
     * @return $this
     * @throws QueryException
     */
    public function setDirective($directive)
    {
        if (!$this->isValid($directive)) {
            throw new QueryException('Directive ' . $directive . ' is not valid');
        }
        $this->directive = $directive;

        return $this;
    }

    /**
     * @return string
     */
    public function getDirective()
    {
        return $this->directive;
    }

    /**
     * @param  string $operation
     * @return $this
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @return bool
     */
    public function isIncludeDirective()
    {
        return $this->directive === self::DIRECTIVE_INCLUDE;
    }

    /**
     * @return bool
     */
    public function isSkipDirective()
    {
        return $this->directive === self::DIRECTIVE_SKIP;
    }

    /**
     * @param  string $directive
     * @return bool
     */
    public function isValid($directive)
    {
        return in_array($directive, $this->getDirectives());
    }

    /**
     * @return array
     */
    public function getDirectives()
    {
        return [
            self::DIRECTIVE_INCLUDE,
            self::DIRECTIVE_SKIP,
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf(
            '@%s(if: %s)',
            $this->getDirective(),
            $this->getOperation()
        );
    }
}