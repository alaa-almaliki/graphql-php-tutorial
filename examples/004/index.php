<?php
use GraphQL\Client\Query\Field;
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/004/graphql.php';
#$query = {"query": "query { first_name, last_name, occupation, years, salary, is_php }"};

$firstNameField = new Field('first_name'); // string
$lastNameField = new Field('last_name'); // string
$occupationField = new Field('occupation'); // string
$yearsField = new Field('years'); // int
$salaryField = new Field('salary'); // decimal
$isphpField = new Field('is_php'); // bool



$parser = new \GraphQL\Client\Query\Parser();
$parser->setFields([
    $firstNameField,
    $lastNameField,
    $occupationField,
    $yearsField,
    $salaryField,
    $isphpField
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