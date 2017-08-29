<?php
namespace GraphQL\Client\Query;

use GraphQL\Client\Query\Field\ArgumentInterface;

/**
 * Interface FieldInterface
 * @package GraphQL\Client\Query
 * @author Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface FieldInterface extends QueryInterface
{
    /**
     * @param  string $aliasName
     * @return mixed
     */
    public function setAliasName($aliasName);

    /**
     * @return mixed
     */
    public function getAliasName();

    /**
     * @param  array $arguments
     * @return mixed
     */
    public function setArguments(array $arguments = []);

    /**
     * @return mixed
     */
    public function getArguments();

    /**
     * @param  string $name
     * @param  string $value
     * @return mixed
     */
    public function addArgument($name, $value);

    /**
     * @param  ArgumentInterface $argument
     * @return mixed
     */
    public function addArgumentObject(ArgumentInterface $argument);

    /**
     * @param  ArgumentInterface $argument
     * @return mixed
     */
    public function removeArgument(ArgumentInterface $argument);

    /**
     * @return mixed
     */
    public function hasArguments();

    /**
     * @return int
     */
    public function getArgumentsCount();

    /**
     * @param  FieldInterface $field
     * @return mixed
     */
    public function addField(FieldInterface $field);

    /**
     * @param  FieldInterface $field
     * @return mixed
     */
    public function removeField(FieldInterface $field);

    /**
     * @return array
     */
    public function getFields();

    /**
     * @param  string $name
     * @return mixed
     */
    public function getField($name);

    /**
     * @param  string $name
     * @return bool
     */
    public function hasField($name);

    /**
     * @return bool
     */
    public function hasFields();

    /**
     * @return int
     */
    public function getFieldsCount();

    /**
     * @return string
     */
    public function getFieldString();
}