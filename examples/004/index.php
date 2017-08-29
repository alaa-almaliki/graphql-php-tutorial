<?php
use GraphQL\Client\Query\Field;
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/004/graphql.php';
#$query = {"query": "query { first_name, last_name, occupation, years, salary, is_php }"};

$parser = new \GraphQL\Client\Query\Parser();
$parser->addFields([
    ['name' => 'first_name'],
    ['name' => 'last_name'],
    ['name' => 'occupation'],
    ['name' => 'years'],
    ['name' => 'salary'],
    ['name' => 'is_php'],
]);

$query  = $parser->parse(); // {"query": "query { first_name, last_name, occupation, years, salary, is_php }"}

$result = $client['send']($url, $query, true);

echo '<h1>Employee</h1>';
foreach ($result as $item) {
    echo '<h2> Full Name: ' . $item['first_name'] . ' ' . $item['last_name'] . '</h2>';
    echo '<h2>Occupation: ' . $item['occupation'] . '</h2>';
    echo '<h2>Years: ' . $item['years'] . '</h2>';
    echo '<h2>Salary: ' . $item['salary'] . '</h2>';
    echo '<h2>PHP Developer: ' . $item['is_php'] . '</h2>';
}