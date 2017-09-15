<?php

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ProductLineType extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'ProductLine',
            'description' => 'ProductLine',
            'fields' => function () {
                return [
                    'productLine' => Type::string(),
                    'textDescription' => Type::string(),
                    'htmlDescription' => Type::string(),
                    'image' => Type::string(),
                    'products' => Type::listOf(Types::product())
                ];
            },
            'resolveField' => function ($value, $args, $context, \GraphQL\Type\Definition\ResolveInfo $info) {
                $method  = 'resolve' . ucfirst($info->fieldName);
                if (method_exists($this, $method)) {
                    return $this->$method($value, $args, $context, $info);
                } else {
                    return $value->{$info->fieldName};
                }
            },
        ];
        parent::__construct($config);
    }

    public function resolveProducts(ProductLine $productLine)
    {
        return (new Product())->list('productLine', $productLine->productLine);
    }
}