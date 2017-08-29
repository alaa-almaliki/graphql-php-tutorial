<?php
namespace GraphQL\Client\Query;

use GraphQL\Client\Query\Field\ArgumentInterface;

interface FieldInterface extends QueryInterface
{
    public function setArguments(array $arguments = []);

    public function getArguments();

    public function addArgument($name, $value);

    public function addArgumentObject(ArgumentInterface $argument);

    public function removeArgument(ArgumentInterface $argument);

    public function hasArguments();

    public function getArgumentsCount();

    public function addField(Field $field);

    public function removeField(FieldInterface $field);

    public function getFields();

    public function hasFields();

    public function getFieldsCount();

    public function getFieldString();
}