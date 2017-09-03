<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/009/graphql.php';

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
    'name' => 'id'
], 'user');


$queryBuilder->addFragment('user', [
    'name' => 'requiredField',
    'type_name' => 'User',
    'fields' => [
        'firstName',
        'lastName',
        'email',
        'phoneNumber'
    ]
]);

$queryBuilder->addVariable('id', 'Int', 3);

$query = $parser->parse(true); // {"query":"query person ( $id : Int ) { user( id: $id ){ id, ...requiredFields } } fragment requiredFields on User { firstName lastName email phoneNumber }","variables":{"id":3}}

$result = $client['send']($url, $query, true);
echo '<br />';

echo '<pr />';
echo implode('<br />', $result['data']['user']);