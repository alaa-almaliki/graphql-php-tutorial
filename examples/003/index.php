<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/003/graphql.php';
#$query = '{"query":"query salute { greetings } "}';

$field = new \GraphQL\Client\Query\Field();
$field->setName('greetings');
$parser = new \GraphQL\Client\Query\Parser();

#$field->addArgument('name', 'Alaa'); // omit the argument - uncomment to use the provided args
$queryBuilder = $parser->createQueryBuilder('salute');
$queryBuilder->addFieldObject($field);

$query  = $parser->parse(true); // {"query":"query salute { greetings } "}
$result = $client['send']($url, $query, true);

foreach ($result as $item) {
    echo '<h1>' . $item['greetings'] . '</h1>';
}