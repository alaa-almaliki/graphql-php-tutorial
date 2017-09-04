<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/010/graphql.php';

$parser = new \GraphQL\Client\Query\Parser();
$queryBuilder = $parser->createQueryBuilder('person');

$queryBuilder->addNewField([
    'name' => 'user',
    'arguments' => [
        [
            'name' => 'id',
            'value' => '$id'
        ]
    ]
]);

$queryBuilder->addNewField([
    'name' => 'id',
    'directive' => [
        'directive' => 'include',
        'operation' => '$WithPhoneNumber'
    ]
], 'user');


$queryBuilder->addFragment('user', [
    'name' => 'requiredField',
    'type_name' => 'User',
    'fields' => [
        'firstName',
        'lastName',
        'email',
        'phoneNumber'
    ],
]);

$queryBuilder->addVariable('id', 'Int', 3);
$queryBuilder->addVariable('WithPhoneNumber', 'Boolean', null, 'false');

$query = $parser->parse(true);

$result = $client['send']($url, $query, true);
echo '<br />';

echo '<pr />';
echo implode('<br />', $result['data']['user']);