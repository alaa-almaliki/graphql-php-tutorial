<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/006/graphql.php';

$parser = new \GraphQL\Client\Query\Parser();
$queryBuilder = $parser->createQueryBuilder('person');

$queryBuilder->addNewField([
        'name' => 'user',
        'arguments' => [
            [
                'name' => 'id',
                'value' => 1
            ]
        ]

]);

$queryBuilder->addNewField(['name' => 'id'], 'user');
$queryBuilder->addNewField(['name' => 'firstName'], 'user');
$queryBuilder->addNewField(['name' => 'lastName'], 'user');
$queryBuilder->addNewField(['name' => 'email'], 'user');
$queryBuilder->addNewField(['name' => 'phoneNumber'], 'user');


$query = $parser->parse(true); // {"query":"query person { user( id: 3 ){ id, firstName, lastName, email, phoneNumber, } } "}


$result = $client['send']($url, $query, true);

echo '<pr />';
echo implode('<br />', $result['data']['user']);