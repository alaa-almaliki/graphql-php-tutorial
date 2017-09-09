<?php

use GraphQL\Type\Definition\InterfaceType;

class NodeType extends InterfaceType
{
    public function __construct()
    {
        $config = [
            'name' => 'Node',
            'fields' => [
                'id' => Types::id()
            ],
            'resolveType' => [$this, 'resolveNodeType']
        ];
        parent::__construct($config);
    }

    public function resolveNodeType($object)
    {
        if ($object instanceof Customer) {
            return Types::customer();
        } else if ($object instanceof Employee) {
            return Types::employee();
        }
    }
}