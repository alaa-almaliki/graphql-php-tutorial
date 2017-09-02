<?php
namespace GraphQL\Client\Query;

/**
 * Class Variables
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Variables
{
    /** @var array  */
    private $variables = [];

    /**
     * Variables constructor.
     * @param array $variables
     */
    public function __construct(array $variables = [])
    {
        $this->variables = $variables;
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }

    /**
     * @param  string $varName
     * @param  string $varType
     * @param  string $varValue
     * @return $this
     */
    public function addVariable($varName, $varType, $varValue)
    {
        if (!$this->hasVariable($varName)) {
            $this->variables[$varName] = [
                'type' => $varType,
                'value' => $varValue
            ];
        }

        return $this;
    }

    /**
     * @param  string $varName
     * @return $this
     */
    public function removeVariable($varName)
    {
        if ($this->hasVariable($varName)) {
            unset($this->variables[$varName]);
        }

        return $this;
    }

    /**
     * @param  string $varName
     * @return bool
     */
    public function hasVariable($varName)
    {
        return array_key_exists($varName, $this->variables);
    }

    /**
     * @return int
     */
    public function getVariablesCount()
    {
        return count($this->variables);
    }

    /**
     * @return bool
     */
    public function hasVariables()
    {
        return $this->getVariablesCount() > 0;
    }

    /**
     * @return array
     */
    public function getVariableParams()
    {
        $params = [];
        if (!$this->hasVariables()) {
            return $params;
        }


        foreach ($this->getVariables() as $varName => $var) {
            $params[] = sprintf('$%s : %s', $varName, $var['type']);
        }

        return $params;
    }

    /**
     * @return string
     */
    public function getVariablesConstruct()
    {
        if (empty($this->getVariableParams())) {
            return '';
        }
        return sprintf('( %s )', implode(', ', $this->getVariableParams()));
    }
}