<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/001/helloworld.php';
#$query = '{"query":"query salute { greetings } "}';

$parser = new \GraphQL\Client\Query\Parser();
$queryBuilder = $parser->createQueryBuilder('salute');
$queryBuilder->addNewField(['name' => 'greetings']);

$query  =  $parser->parse(true); // {"query":"query salute { greetings } "}
$result = $client['send']($url, $query);

foreach (json_decode($result, true) as $item) {
    echo '<h1>' . $item['greetings'] . '</h1>';
}