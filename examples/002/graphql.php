<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR .  'bootstrap.php';

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;

try {
    $queryType = new ObjectType([
        'name' => 'Query',
        'description'=> 'Greetings with required arguments',
        'fields' => [
            'greetings' => [
                'type' => Type::string(),
                'args' => [
                    'name' => Type::nonNull(Type::string()),
                ],
                'resolve' => function ($root, $args) {
                    return $root['message'] . ' ' . $args['name'];
                }
            ],
        ],
    ]);

    $schema = new Schema([
        'query' => $queryType,
    ]);

    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    $query = $input['query'];
    $rootValue = ['message' => 'Hello'];

    $result = GraphQL::executeQuery($schema, $query, $rootValue);
    $output = $result->toArray();
} catch (\Exception $e) {
    $output = [
        'error' => [
            'message' => $e->getMessage()
        ]
    ];
}
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($output);