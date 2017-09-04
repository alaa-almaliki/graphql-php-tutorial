<?php
namespace GraphQL\Client\Query;

use GraphQL\Client\Query\Utils\Data\Normaliser;
use GraphQL\Client\Query\Utils\ObjectFactory;

/**
 * Class Query
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class QueryBuilder extends AbstractQuery
{
    /** @var KeyWord  */
    private $keyWord;
    /** @var array  */
    private $fields = [];
    /** @var array  */
    private $fragments = [];
    /** @var array  */
    private $inlineFragments = [];
    /** @var  Variables */
    private $variables;

    /**
     * Query constructor.
     * @param string|null $name
     * @param string $keyWord
     */
    public function __construct($name = null, $keyWord = KeyWord::KEY_WORD_QUERY)
    {
        parent::__construct($name);
        $this->keyWord      = new KeyWord($keyWord);
        $this->variables    = new Variables();
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
     * @param  string $defaultValue
     * @return $this
     */
    public function addVariable($varName, $varType, $varValue, $defaultValue = null)
    {
        $this->variables->addVariable($varName, $varType, $varValue, $defaultValue);
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
     * @param  string $keyWord
     * @return $this
     */
    public function setKeyWord($keyWord)
    {
        $this->keyWord->setKeyword($keyWord);
        return $this;
    }

    /**
     * @return string
     */
    public function getKeyWord()
    {
        return $this->keyWord->getKeyWord();
    }

    /**
     * @param string $name
     * @param string|null $aliasName
     * @param array $argumentData
     * @param array $fragmentData
     * @param array $inlineFragmentData
     * @param array $directiveData
     * @param array $fields
     * @return Field
     */
    private function createNewField(
        $name,
        $aliasName = null,
        array $argumentData = [],
        array $fragmentData = [],
        array $inlineFragmentData = [],
        array $directiveData = [],
        array $fields = []
    )
    {
        return ObjectFactory::createField(
            $name,
            $aliasName,
            $argumentData,
            $fragmentData,
            $inlineFragmentData,
            $directiveData,
            $fields
        );
    }

    /**
     * @param  array $fieldData
     *        $fieldData = [
     *        'name' => '' , //field name
     *        'alias_name' => '', // field alias name
     *        'arguments' => [ // field arguments - array of arrays
     *            [
     *                'name' => '', // argument name
     *                'value' => '', // argument value
     *            ]
     *        ],
     *        'fragment' => [ // field fragment  - array
     *           'name' => '', // fragment name
     *           'type' => '', // Query type defined in the api,
     *            'fields' => [ // fields included in the fragment
     *                'field1',
     *                'field2',
     *                'field3',
     *                '...'
     *            ]
     *        ],
     *        'inline_fragment' => [ // field inline fragment - inline fragment has no name
     *            'type' => '', // Query type defined in the api,
     *            'fields' => [ // fields included in the fragment
     *                'field1',
     *                'field2',
     *                'field3',
     *                '...'
     *            ]
     *        ],
     *        'directive' => [ // field directive
     *            'directive' => '', // could be include or skip
     *            'operation' => '', // starts with $ sign, this is the argument passed into here
     *        ],
     *        'fields' => [ // array of array, repeat field definition mentioned above
     *            [
     *                'name',
     *                '.....',
     *                'fields' => [],
     *            ]
     *        ]
     *    ];
     *
     * @param  string|null $parentFieldName
     * @return $this
     */
    public function addNewField(array $fieldData, $parentFieldName = null)
    {
        $field = Normaliser::normaliseFieldData($fieldData);
        $newField = $this->createNewField(
            $field['name'],
            $field['alias_name'],
            $field['arguments'],
            $field['fragment'],
            $field['inline_fragment'],
            $field['directive'],
            $field['fields']
        );

        if ($parentFieldName !== null) {
            $field = $this->getField($parentFieldName);
            $field->addField($newField);
        } else {
            $this->fields[$newField->getName()] = $newField;
        }

        if ($newField->hasFragment()) {
            $this->fragments[$newField->getName()] = $newField->getFragment();
        }

        return $this;
    }

    /**
     * @param  array $data
     * @return $this
     */
    public function addFields(array $data)
    {
        foreach ($data as $fieldData) {

            $this->addNewField($fieldData);
        }

        return $this;
    }

    /**
     * @param  string $fieldName
     * @param  array $arguments
     * @param  string|null $parentFieldName
     * @return $this
     */
    public function addArgumentsToField($fieldName, array $arguments, $parentFieldName = null)
    {
        $field = $this->getField($fieldName, $parentFieldName);
        foreach ($arguments as $argName => $argValue) {
            $field->addArgument($argName, $argValue);
        }

        return $this;
    }

    /**
     * @param  string $fieldName
     * @param  string $aliasName
     * @param  string|null $parentFieldName
     * @return $this
     */
    public function setFieldAliasName($fieldName, $aliasName, $parentFieldName = null)
    {
        $field = $this->getField($fieldName, $parentFieldName);
        $field->setAliasName($aliasName);
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
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param  string $fieldName
     * @param  array $fragmentData
     * @param  string|null $parentFieldName
     * @return $this
     */
    public function addInlineFragmentToField($fieldName, array $fragmentData, $parentFieldName = null)
    {
        $normalisedData = Normaliser::normaliseFragmentData($fragmentData);
        $inlineFragment = ObjectFactory::createInlineFragment($normalisedData['type'], $normalisedData['fields']);
        /** @var Field $field */
        $field = $this->getField($fieldName, $parentFieldName)->setInlineFragment($inlineFragment);
        $this->inlineFragments[$field->getName()] = $inlineFragment;
        return $this;
    }

    /**
     * @param  string $fieldName
     * @param  array $fragmentData
     * @param  string|null $parentFieldName
     * @return $this
     */
    public function addFragment($fieldName, array $fragmentData, $parentFieldName = null)
    {
        $normalisedData = Normaliser::normaliseFragmentData($fragmentData);
        $fragment = ObjectFactory::createFragment(
            $normalisedData['name'],
            $normalisedData['type'],
            $normalisedData['fields']
        );
        $field = $this->getField($fieldName, $parentFieldName)->setFragment($fragment);
        $this->fragments[$field->getName()] = $fragment;
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
        unset($this->fragments[$fieldName]);
        return $this;
    }

    /**
     * @param  string $fieldName
     * @param  FragmentInterface $fragment
     * @return bool
     */
    public function hasFragment($fieldName, FragmentInterface $fragment)
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
        return count($this->getFragments());
    }

    /**
     * @return array
     */
    public function getFragments()
    {
        return $this->fragments;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $fragmentStr = '';
        if ($this->hasFragments()) {
            $fragmentStr .= implode(', ', $this->getFragments());
        }

        return sprintf(
            '%s %s %s { %s } %s',
            $this->getKeyWord(),
            $this->getName(),
            $this->variables->getVariablesConstruct(),
            implode(', ', $this->getFields()),
            $fragmentStr
        );
    }
}