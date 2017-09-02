<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/002/graphql.php';
#$query = '{"query":"query salute { greetings( name: \"Alaa\" ) } "}';

$field = new \GraphQL\Client\Query\Field();
$field->setName('greetings');
$field->addArgument('name', 'Alaa');
$parser = new \GraphQL\Client\Query\Parser();
$queryBuilder = $parser->createQueryBuilder('salute');
$queryBuilder->addFieldObject($field);

$query =  $parser->parse(true); // {"query":"query salute { greetings( name: \"Alaa\" ) } "}
$result = $client['send']($url, $query, true);

foreach ($result as $item) {
    echo '<h1>' . $item['greetings'] . '</h1>';
}