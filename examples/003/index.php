<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/003/graphql.php';
$parser = new \GraphQL\Client\Query\Parser();
$queryBuilder = $parser->createQueryBuilder('salute');
$queryBuilder->addNewField([
        'name' => 'greetings',
        'arguments' => [ // optional  - comment to retrieve the default value
            [
                'name' => 'name',
                'value' => 'Alaa',
            ]
        ],
]);

$query  = $parser->parse(true); // {"query":"query salute { greetings } "}
$result = $client['send']($url, $query, true);

foreach ($result as $item) {
    echo '<h1>' . $item['greetings'] . '</h1>';
}