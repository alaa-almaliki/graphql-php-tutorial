<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/001/helloworld.php';
#$query = '{"query": "query { greetings }"}';

$field = new \GraphQL\Client\Query\Field();
$field->setName('greetings');
$parser = new \GraphQL\Client\Query\Parser($field);
$query =  $parser->parse(); // '{"query": "query { greetings }"}'

$result = $client['send']($url, $query);

foreach (json_decode($result, true) as $item) {
    echo '<h1>' . $item['greetings'] . '</h1>';
}