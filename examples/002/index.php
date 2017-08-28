<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/002/graphql.php';
$query = '{"query": "query { greetings(name: \"Alaa\")}"}';
$result = $client['send']($url, $query, true);

foreach ($result as $item) {
    echo '<h1>' . $item['greetings'] . '</h1>';
}