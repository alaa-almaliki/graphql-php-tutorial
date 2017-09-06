<?php
require_once  './includes.php';

$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/011/graphql.php';

$parser = new \GraphQL\Client\Query\Parser();
$queryBuilder = $parser->createQueryBuilder('query1');

$queryBuilder->addNewField([
   'name' => 'customer',
    'arguments' => [
        [
            'name' => 'customerNumber',
            'value' => 103,
        ]
    ],
]);

$queryBuilder->getField('customer')->addField(new \GraphQL\Client\Query\Field('customerNumber'));

$query = $parser->parse(true);

$result = $client['send']($url, $query, true);

echo '<pre>';

print_r($result);