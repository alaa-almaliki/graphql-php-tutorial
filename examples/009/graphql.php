<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR .  'bootstrap.php';
require_once './User.php';
require_once './UserType.php';

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;

try {

    function user($args) {
        return (new User())->getById($args['id']);
    }

    $userType = new UserType();
    $queryType = new ObjectType([
        'name' => 'Query',
        'description'=> 'Greetings with optional arguments',
        'fields' => [
            'user' => [
                'type' => $userType,
                'args' => [
                    'id' => Type::int()
                ]
            ],
        ],
        'resolveField' => function($val, $args, $context, ResolveInfo $info) {
            $method = $info->fieldName; // user  - line 16
            return $method($args);
        }
    ]);

    $schema = new Schema([
        'query' => $queryType,
    ]);

    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    $query = $input['query'];
    $variableValues = isset($input['variables']) ? $input['variables'] : null;


    $result = GraphQL::executeQuery($schema, $query, null, null, $variableValues);
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