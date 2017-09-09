<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/007/graphql.php';

$parser = new \GraphQL\Client\Query\Parser();
$queryBuilder = $parser->createQueryBuilder('person');

$queryBuilder->addNewField([
    'name' => 'user',
    'arguments' => [
        [
            'name' => 'id',
            'value' => 1
        ]
    ],
    'fragment' => [
        'name' => 'requiredFields',
        'type_name' => 'User',
        'fields' => [
            'firstName',
            'lastName',
            'email',
            'phoneNumber'
        ]
    ]

]);

$queryBuilder->addNewField([
    'name' => 'id'
], 'user');

$query = $parser->parse(true); // {"query":"query person { user( id: 3 ){ id, ...requiredFields } } fragment requiredFields on User { firstName lastName email phoneNumber }"}


$result = $client['send']($url, $query, true);

echo '<pr />';
echo implode('<br />', $result['data']['user']);