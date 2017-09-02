<?php
namespace GraphQL\Client\Query;

use GraphQL\Client\Query\Fragment\Data\Normaliser;
use GraphQL\Client\Query\Fragment\Inline;

/**
 * Class Query
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class QueryBuilder extends AbstractQuery
{
    /** @var string */
    private $typeName;
    /** @var KeyWord  */
    private $keyWord;
    /** @var array  */
    private $fields = [];
    /** @var array  */
    private $fragments = [];
    /** @var  Variables */
    private $variables;

    /**
     * Query constructor.
     * @param string|null $name
     * @param string $typeName
     */
    public function __construct($name = null, $typeName = KeyWord::KEY_WORD_QUERY)
    {
        parent::__construct($name);
        $this->keyWord = new KeyWord();
        $this->variables = new Variables();

        $this->setQueryKeyWord($typeName);
    }

    /**
     * @return Variables
     */
    public function getVariablesObject()
    {
        return $this->variables;
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return $this->getVariablesObject()->getVariables();
    }

    /**
     * @param  string $varName
     * @param  string $varType
     * @param  string $varValue
     * @return $this
     */
    public function addVariable($varName, $varType, $varValue)
    {
        $this->variables->addVariable($varName, $varType, $varValue);
        return $this;
    }

    /**
     * @param  string $varName
     * @return $this
     */
    public function removeVariable($varName)
    {
        $this->variables->removeVariable($varName);
        return $this;
    }

    /**
     * @param  string $typeName
     * @return $this
     */
    public function setQueryKeyWord($typeName)
    {
        $this->validateQueryKeyWord($typeName);
        $this->typeName = $typeName;
        return $this;
    }

    /**
     * @return string
     */
    public function getQueryKeyWord()
    {
        return $this->typeName;
    }

    /**
     * @param  string $queryType
     * @return $this
     * @throws QueryException
     */
    protected function validateQueryKeyWord($queryType)
    {
        if (!$this->keyWord->isValid($queryType)) {
            throw new QueryException($queryType . ' is not a valid query');
        }

        return $this;
    }

    /**
     * @param  string $name
     * @param  array $arguments
     * @param  string|null $aliasName
     * @return Field
     */
    private function createNewField($name, array $arguments = [], $aliasName = null)
    {
        $field = new Field($name);
        $field->setAliasName($aliasName);
        foreach ($arguments as $argName => $argValue) {
            $this->_addArgumentToField($field, $argName, $argValue);
        }

        return $field;
    }

    /**
     * @param  string $name
     * @param  array $arguments
     * @param  string|null $aliasName
     * @return $this
     */
    public function addNewField($name, array $arguments = [], $aliasName = null)
    {
        return $this->addFieldObject($this->createNewField($name, $arguments, $aliasName));
    }

    /**
     * @param  string $parentName
     * @param  string $childName
     * @param  array $arguments
     * @param  string|null $aliasName
     * @return $this
     */
    public function addChildField($parentName, $childName, array $arguments = [], $aliasName = null)
    {
        $parentField = $this->getField($parentName);
        $childField  = $this->createNewField($childName, $arguments, $aliasName);
        $parentField->addField($childField);
        return $this;
    }

    /**
     * @param  string $name
     * @param  array $arguments
     * @return $this
     */
    public function addArgumentsToField($name, array $arguments = [])
    {
        $field = $this->getField($name);
        foreach ($arguments as $argName => $argValue) {
            $this->_addArgumentToField($field, $argName, $argValue);
        }

        return $this;
    }

    /**
     * @param  string $name
     * @param  string $argName
     * @param  string|int|mixed $argValue
     * @return $this
     * @throws QueryException
     */
    public function addArgumentToField($name, $argName, $argValue)
    {
        if (empty($argName) || empty($argValue)) {
            throw new QueryException('Argument has no name or value.');
        }
        $this->_addArgumentToField($this->getField($name), $argName, $argValue);
        return $this;
    }

    /**
     * @param  string $name
     * @param  string $aliasName
     * @return mixed
     */
    public function setFieldAliasName($name, $aliasName)
    {
        $field = $this->getField($name);
        return $field->setAliasName($aliasName);
    }

    /**
     * @param  FieldInterface $field
     * @param  string $aliasName
     * @return $this
     */
    protected function _setFieldAliasName(FieldInterface $field, $aliasName)
    {
        $field->setAliasName($aliasName);
        return $this;
    }

    /**
     * @param  FieldInterface $field
     * @param  string $argName
     * @param  string|int|mixed $argValue
     * @param  string|null $aliasName
     * @return $this
     */
    protected function _addArgumentToField(FieldInterface $field, $argName, $argValue, $aliasName = null)
    {
        $field->addArgument($argName, $argValue);
        if ($aliasName !== null) {
            $field->setAliasName($aliasName);
        }
        return $this;
    }

    /**
     * @param  string $name
     * @param  string $parentName
     * @return FieldInterface
     * @throws QueryException
     */
    public function getField($name, $parentName = null)
    {
        if ($parentName !== null) {
            foreach ($this->getFields() as $fieldName => $field) {
                if ($parentName === $fieldName) {
                    return $field->getField($name);
                }
            }
        }

        return $this->fields[$name];
    }

    /**
     * @param  FieldInterface $field
     * @return $this
     */
    public function addFieldObject(FieldInterface $field)
    {
        $this->fields[$field->getName()] = $field;
        return $this;
    }

    /**
     * @param  array $fields
     * @return $this
     */
    public function addFields(array $fields = [])
    {
        foreach ($fields as $field) {
            $aliasName = isset($field['alias_name']) ? $field['alias_name'] : null;
            $args = isset($field['args']) ? $field['args'] : [];
            $this->addNewField($field['name'], $args, $aliasName);
        }
        return $this;
    }

    /**
     * @param  array $fields
     * @return $this
     */
    public function setFields(array $fields)
    {
        foreach ($fields as $field) {
            $this->addFieldObject($field);
        }

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
     * @param  string $fragmentName
     * @param  string $typeName
     * @param  array $fields
     * @return Fragment
     */
    public function createFragment($fragmentName, $typeName, array $fields)
    {
        $fragment = new Fragment($fragmentName);
        $fragment->setTypeName($typeName)
            ->setFields($fields);

        return $fragment;
    }

    /**
     * @param  string $typeName
     * @param  array $fields
     * @return Fragment
     */
    public function createInlineFragment($typeName, array $fields)
    {
        return $this->createFragment(null, $typeName, $fields);
    }

    /**
     * @param  string $fieldName
     * @param  array $fragmentData
     * @return $this
     */
    public function addInlineFragmentToField($fieldName, array $fragmentData)
    {
        $normalised = Normaliser::normalise($fragmentData);
        $inlineFragment = new Inline();
        $inlineFragment->setTypeName($normalised['type']);
        $inlineFragment->setFields($normalised['fields']);
        $this->getField($fieldName)->setInlineFragment($inlineFragment);
        return $this;
    }

    /**
     * @param  array $fragmentData
     * @return $this
     */
    public function addFragment(array $fragmentData)
    {
        $normalisedData = Normaliser::normalise($fragmentData);

        return $this->addFragmentObject(
            $fragmentData['field'],
            $this->createFragment($normalisedData['name'], $normalisedData['type'], $normalisedData['fields'])
        );
    }

    /**
     * @param  array $fragments
     * @return $this
     */
    public function addFragments(array $fragments)
    {
        foreach ($fragments as $fragment) {
            $this->addFragment($fragment);
        }

        return $this;
    }

    /**
     * @param  string $fieldName
     * @param  Fragment $fragment
     * @return $this
     * @throws QueryException
     */
    public function addFragmentObject($fieldName, Fragment $fragment)
    {
        if ($this->hasFragment($fieldName, $fragment)) {
            $msg = sprintf(
                'Fragment %s already associated with field %s',
                $fragment->getName(),
                $fieldName
            );
            throw new QueryException($msg);
        }

        $this->fragments[$fieldName] = $fragment;
        $this->getField($fieldName)->setFragment($fragment);
        return $this;
    }

    /**
     * @param  string $fieldName
     * @param  Fragment $fragment
     * @return $this
     * @throws QueryException
     */
    public function removeFragment($fieldName, Fragment $fragment)
    {
        if (!$this->hasFragment($fieldName, $fragment)) {
            $msg = sprintf(
                'Fragment %s is not associated with field %s',
                $fragment->getName(),
                $fieldName
            );
            throw new QueryException($msg);
        }
        unset($this->fragments[$fieldName]);
        return $this;
    }

    /**
     * @param  string $fieldName
     * @param  Fragment $fragment
     * @return bool
     */
    public function hasFragment($fieldName, Fragment $fragment)
    {
        return isset($this->fragments[$fieldName]) &&
            $this->fragments[$fieldName]->getName() === $fragment->getName();
    }

    /**
     * @return bool
     */
    public function hasFragments()
    {
        return $this->getFragmentsCount() > 0;
    }

    /**
     * @return int
     */
    public function getFragmentsCount()
    {
        return count($this->fragments);
    }

    /**
     * @return array
     */
    public function getFragments()
    {
        return $this->fragments;
    }

    public function __toString()
    {
        $fragmentStr = '';
        if ($this->hasFragments()) {
            $fragmentStr .= implode(', ', $this->getFragments());
        }

        return sprintf(
            '%s %s %s { %s } %s',
            $this->getQueryKeyWord(),
            $this->getName(),
            $this->variables->getVariablesConstruct(),
            implode(', ', $this->getFields()),
            $fragmentStr
        );
    }
}