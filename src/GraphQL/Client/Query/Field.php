<?php
namespace GraphQL\Client\Query;

use GraphQL\Client\Query\Field\Argument;
use GraphQL\Client\Query\Field\ArgumentInterface;
use GraphQL\Client\Query\Fragment\Inline;

/**
 * Class Field
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Field extends AbstractQuery implements FieldInterface
{
    /** @var  string */
    private $aliasName;
    /** @var array  */
    private $arguments = [];
    /** @var array  */
    private $fields = [];
    /** @var  Fragment */
    private $fragment;
    /** @var  Inline */
    private $inlineFragment;

    /**
     * Field constructor.
     * @param string|null $name
     * @param string|null $aliasName
     * @param array $arguments
     */
    public function __construct($name = null, $aliasName = null, array $arguments = [])
    {
        parent::__construct($name);
        $this->aliasName = $aliasName;
        $this->setArguments($arguments);
    }

    /**
     * @param  string $aliasName
     * @return $this
     */
    public function setAliasName($aliasName)
    {
        $this->aliasName = $aliasName;
        return $this;
    }

    /**
     * @return string
     */
    public function getAliasName()
    {
        return $this->aliasName;
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
     * @throws QueryException
     */
    public function addArgumentObject(ArgumentInterface $argument)
    {
        $argName = $argument->getName();
        if ($this->hasArgument($argName)) {
            throw new QueryException('Argument with name ' . $argName . ' already exists.');
        }

        $this->arguments[$argument->getName()] = $argument;
        return $this;
    }

    /**
     * @param  ArgumentInterface $argument
     * @return $this
     * @throws QueryException
     */
    public function removeArgument(ArgumentInterface $argument)
    {
        $argName = $argument->getName();
        if (!$this->hasArgument($argName)) {
            throw new QueryException('Argument with name ' . $argName . ' does not exist.');
        }
        unset($this->arguments[$argument->getName()]);
        return $this;
    }

    /**
     * @param  string $name
     * @return bool
     */
    public function hasArgument($name)
    {
        return isset($this->arguments[$name]);
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
     * @throws QueryException
     */
    public function addField(FieldInterface $field)
    {
        $fieldName = $field->getName();
        if ($this->hasField($fieldName)) {
            throw new QueryException('Field with name ' . $fieldName . ' already exists.');
        }
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    /**
     * @param string $name
     * @return FieldInterface
     * @throws QueryException
     */
    public function getField($name)
    {
        if (!$this->hasField($name)) {
            throw new QueryException('Field ' . $name . ' is not found');
        }

        return $this->fields[$name];
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
     * @param  string $name
     * @return bool
     */
    public function hasField($name)
    {
        return isset($this->fields[$name]);
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
     * @param  Fragment $fragment
     * @return $this
     */
    public function setFragment(Fragment$fragment)
    {
        $this->fragment = $fragment;
        return $this;
    }

    /**
     * @return FragmentInterface
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @param Inline $inlineFragment
     * @return $this
     */
    public function setInlineFragment(Inline $inlineFragment)
    {
        $this->inlineFragment = $inlineFragment;
        return $this;
    }

    /**
     * @return Inline
     */
    public function getInlineFragment()
    {
        return $this->inlineFragment;
    }

    /**
     * @return bool
     */
    public function hasInlineFragment()
    {
        return $this->inlineFragment !== null;
    }

    /**
     * @return bool
     */
    public function hasFragment()
    {
        return $this->fragment !== null;
    }

    /**
     * @return string
     */
    public function getFieldString()
    {
        $str =  $this->getName();

        if ($this->getAliasName() !== null) {
            $str = $this->getAliasName() . ' : ' . $this->getName();
        }

        if ($this->hasArguments()) {
            $str .= '( %s )';
        }
        return sprintf($str, implode(', ', $this->getArguments()));
    }

    /**
     * @return string
     */
    protected function getFragmentString()
    {
        $fragmentStr = '';

        if ($this->hasFragment()) {
            $fragmentStr .= '...' . $this->getFragment()->getName();
        }

        return $fragmentStr;
    }

    /**
     * @return string
     */
    protected function getInlineFragmentString()
    {
        $fragmentStr = '';

        if ($this->hasInlineFragment()) {
            $fragmentStr .= $this->getInlineFragment();
        }

        return $fragmentStr;
    }

    /**
     * @return string
     */
    protected function constructFragments()
    {
        return sprintf('%s %s', $this->getFragmentString(), $this->getInlineFragmentString());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $toString = $this->getFieldString();
        if ($this->hasFields()) {

            $toString .= sprintf('{ %s,  %s}', implode(', ', $this->getFields()), $this->constructFragments());
        }

        return $toString;
    }
}