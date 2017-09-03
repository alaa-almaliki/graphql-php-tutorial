<?php
namespace GraphQL\Client\Query\Utils;

use GraphQL\Client\Query\Field;
use GraphQL\Client\Query\Field\Argument;
use GraphQL\Client\Query\Field\Directive;
use GraphQL\Client\Query\Fragment;
use GraphQL\Client\Query\Fragment\Inline;
use GraphQL\Client\Query\Variables;

/**
 * Class ObjectFactory
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ObjectFactory
{
    /**
     * @param  string $name
     * @param  string $typeName
     * @param  array $fields
     * @return Fragment
     */
    static public function createFragment($name, $typeName, array $fields)
    {
        return new Fragment($name, $typeName, $fields);
    }

    /**
     * @param  string $typeName
     * @param  array $fields
     * @return Inline
     */
    static public function createInlineFragment($typeName, array $fields)
    {
        return new Inline($typeName, $fields);
    }

    /**
     * @param  string $name
     * @param  string $value
     * @return Argument
     */
    static public function createArgument($name, $value)
    {
        return new Argument($name, $value);
    }

    /**
     * @param  string $directive
     * @param  string $operation
     * @return Directive
     */
    static public function createDirective($directive, $operation)
    {
        return new Directive($directive, $operation);
    }

    /**
     * @param  array $variables
     * @return Variables
     */
    static public function createVariables(array $variables)
    {
        return new Variables($variables);
    }

    /**
     * @param  string $name
     * @param  string| null $aliasName
     * @param  array $argumentData
     * @param  array $fragmentData
     * @param  array $inlineFragmentData
     * @param  array $directiveData
     * @param  array $fields
     * @return Field
     */
    static public function createField(
        $name,
        $aliasName = null,
        array $argumentData = [],
        array $fragmentData = [],
        array $inlineFragmentData = [],
        array $directiveData = [],
        array $fields = []
    )
    {
        $argument           = static::getArguments($argumentData);
        $fragment           = static::getFragment($fragmentData);
        $inlineFragment     = static::getInlineFragment($inlineFragmentData);
        $directiveObject    = static::getDirective($directiveData);

        return new Field(
            $name,
            $aliasName,
            $argument,
            $fragment,
            $inlineFragment,
            $directiveObject,
            $fields
        );
    }

    /**
     * @param  array $argumentData
     * @return array
     */
    static private function getArguments(array $argumentData)
    {
        $arguments = [];
        if (!empty($argumentData)) {
            foreach ($argumentData as $data) {
                $argName        = $data['name'];
                $argValue       = $data['value'];
                $argument       = static::createArgument($argName, $argValue);
                $arguments[]    = $argument;
            }
        }
        return $arguments;
    }

    /**
     * @param  array $fragmentData
     * @return Fragment|null
     */
    static private function getFragment(array $fragmentData)
    {
        $fragment = null;
        if (!empty($fragmentData)) {
            $fragmentName = $fragmentData['name'];
            $typeName = $fragmentData['type_name'];
            $fields = $fragmentData['fields'];
            $fragment = static::createFragment($fragmentName, $typeName, $fields);
        }

        return $fragment;
    }

    /**
     * @param  array $inlineFragmentData
     * @return Inline|null
     */
    static private function getInlineFragment(array $inlineFragmentData)
    {
        $inlineFragment = null;
        if (!empty($inlineFragmentData)) {
            $typeName = $inlineFragmentData['type_name'];
            $fields = $inlineFragmentData['fields'];
            $inlineFragment = static::createInlineFragment($typeName, $fields);
        }

        return $inlineFragment;
    }

    /**
     * @param  array $directiveData
     * @return Directive|null
     */
    static private function getDirective(array $directiveData)
    {
        $directiveObject = null;
        if (!empty($directiveData)) {
            $directive = $directiveData['directive'];
            $operation = $directiveData['operation'];
            $directiveObject = static::createDirective($directive, $operation);
        }

        return $directiveObject;
    }
}