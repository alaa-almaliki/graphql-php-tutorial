<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/005/graphql.php';

$parser = new \GraphQL\Client\Query\Parser();
$queryBuilder = $parser->createQueryBuilder('person');

$queryBuilder->addFields([
    ['name' => 'first_name', 'alias_name' => 'firstName'],
    ['name' => 'last_name', 'alias_name' => 'lastName'],
    ['name' => 'occupation',  'alias_name' => 'job'],
    ['name' => 'years',  'alias_name' => 'experience'],
    ['name' => 'salary',  'alias_name' => 'income'],
    ['name' => 'is_php',  'alias_name' => 'php'],
]);

$query  = $parser->parse(true); // {"query":"query person { firstName : first_name, lastName : last_name, job : occupation, experience : years, income : salary, php : is_php } "}


$result = $client['send']($url, $query, true);

echo '<h1>Employee</h1>';
foreach ($result as $item) {
    echo '<h2> Full Name: ' . $item['firstName'] . ' ' . $item['lastName'] . '</h2>';
    echo '<h2>Occupation: ' . $item['job'] . '</h2>';
    echo '<h2>Years: ' . $item['experience'] . '</h2>';
    echo '<h2>Salary: ' . $item['income'] . '</h2>';
    echo '<h2>PHP Developer: ' . $item['php'] . '</h2>';
}