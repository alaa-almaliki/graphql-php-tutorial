<?php
namespace GraphQL\Client\Query;

/**
 * Class Parser
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Parser
{
    const QUERY_TYPE_QUERY = 'query';
    const QUERY_TYPE_MUTATION = 'mutation';

    /** @var string  */
    private $queryString = '{"query": "%s { %s } %s "}';
    /** @var string  */
    private $type;
    /** @var array  */
    private $fields = [];
    /** @var array  */
    private $fragements = [];

    /**
     * Parser constructor.
     * @param array $fields
     * @param string $type
     */
    public function __construct($type = self::QUERY_TYPE_QUERY, array $fields = [])
    {
        $this->type = $type;
        $this->setFields($fields);
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
     * @return Parser
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
     * @return Parser
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
     * @return Parser
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
     * @param  string $type
     * @return Parser
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * @param  array $fragmentData
     * @return Parser
     */
    public function addFragment(array $fragmentData)
    {
        $normalisedData = $this->normaliseFragmentData($fragmentData);

        return $this->addFragmentObject(
            $fragmentData['field'],
            $this->createFragment($normalisedData['name'], $normalisedData['type'], $normalisedData['fields'])
        );
    }

    /**
     * @param  array $data
     * @return array
     */
    private function normaliseFragmentData(array $data)
    {
        $normalised = [];

        foreach ($data as $key => $value) {
            if (in_array($key, ['field', 'field_name'])) {
                $normalised['field'] = $value;
            }

            if (in_array($key, ['fragment_name', 'name', 'fragment'])) {
                $normalised['name'] = $value;
            }

            if (in_array($key, ['type', 'type_name'])) {
                $normalised['type'] = $value;
            }
        }

        $normalised['fields'] = $data['fields'];

        return $normalised;
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
     * @param  FragmentInterface $fragment
     * @return $this
     * @throws QueryException
     */
    public function addFragmentObject($fieldName, FragmentInterface $fragment)
    {
        if ($this->hasFragment($fieldName, $fragment)) {
            $msg = sprintf(
                'Fragment %s already associated with field %s',
                $fragment->getName(),
                $fieldName
            );
            throw new QueryException($msg);
        }

        $this->fragements[$fieldName] = $fragment;
        $this->getField($fieldName)->setFragment($fragment);
        return $this;
    }

    /**
     * @param  string $fieldName
     * @param  FragmentInterface $fragment
     * @return $this
     * @throws QueryException
     */
    public function removeFragment($fieldName, FragmentInterface $fragment)
    {
        if (!$this->hasFragment($fieldName, $fragment)) {
            $msg = sprintf(
                'Fragment %s is not associated with field %s',
                $fragment->getName(),
                $fieldName
            );
            throw new QueryException($msg);
        }
        unset($this->fragements[$fieldName]);
        return $this;
    }

    /**
     * @param  string $fieldName
     * @param  FragmentInterface $fragment
     * @return bool
     */
    public function hasFragment($fieldName, FragmentInterface $fragment)
    {
        return isset($this->fragements[$fieldName]) &&
            $this->fragements[$fieldName]->getName() === $fragment->getName();
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
        return count($this->fragements);
    }

    /**
     * @return array
     */
    public function getFragments()
    {
        return $this->fragements;
    }

    /**
     * @param  bool $debug
     * @return string
     */
    public function parse($debug = false)
    {
        $fragmentStr = '';
        if ($this->hasFragments()) {
            $fragmentStr .= implode(', ', $this->getFragments());
        }

        $query =  sprintf(
            $this->queryString,
            $this->getType(),
            implode(', ', $this->getFields()),
            $fragmentStr
        );

        if ($debug) {
            print_r($query);
        }

        return $query;
    }
}