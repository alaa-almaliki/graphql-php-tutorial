<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/003/graphql.php';
#$query = '{"query": "query { greetings(name: \"Alaa\")}"}';

$field = new \GraphQL\Client\Query\Field();
$field->setName('greetings');
#$field->addArgument(new \GraphQL\Client\Query\Argument('name', 'Alaa')); // omit the argument - uncomment to use the provided args
$parser = new \GraphQL\Client\Query\Parser($field);
$query  = $parser->parse(); // '{"query": "query { greetings(name: \"Alaa\")}"}' | '{"query": "query { greetings }"}'


$result = $client['send']($url, $query, true);

foreach ($result as $item) {
    echo '<h1>' . $item['greetings'] . '</h1>';
}