<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR .  'bootstrap.php';

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;

try {
    $queryType = new ObjectType([
        'name' => 'Query',
        'description'=> 'Greetings with optional arguments',
        'fields' => [
            'first_name' => [
                'type' => Type::nonNull(Type::string()),
                'resolve' => function ($root, $args) {
                    return 'Alaa';
                }
            ],
            'last_name' => [
                'type' => Type::nonNull(Type::string()),
                'resolve' => function ($root, $args) {
                    return 'Al-Maliki';
                }
            ],
            'occupation' => [
                'type' => Type::nonNull(Type::string()),
                'resolve' => function ($root, $args) {
                    return 'Software Engineer';
                }
            ],
            'years' => [
                'type' => Type::nonNull(Type::int()),
                'resolve' => function ($root, $args) {
                    return 4;
                }
            ],
            'salary' => [
                'type' => Type::nonNull(Type::float()),
                'resolve' => function ($root, $args) {
                    return 12500.01;
                }
            ],
            'is_php' => [
                'type' => Type::nonNull(Type::boolean()),
                'resolve' => function ($root, $args) {
                    return true;
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

    $result = GraphQL::executeQuery($schema, $query);
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