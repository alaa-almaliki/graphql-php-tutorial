<?php
require_once  './includes.php';

$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/011/graphql.php';

$parser = new \GraphQL\Client\Query\Parser();
$queryBuilder = $parser->createQueryBuilder('query1');

$queryBuilder->addNewField([
   'name' => 'customer',
    'arguments' => [
        [
            'name' => 'id',
            'value' => 103,
        ]
    ],
    'fields' => [
        ['name' => 'id'],
        ['name' => 'customerNumber', 'alias_name' => 'customer_number'],
        ['name' => 'customerName', 'alias_name' => 'customer_name'],
        ['name' => 'contactLastName', 'alias_name' => 'contact_last_name'],
        ['name' => 'contactFirstName', 'alias_name' => 'contact_first_name'],
        ['name' => 'phone'],
        ['name' => 'addressLine1', 'alias_name' => 'address_line_1'],
        ['name' => 'addressLine2', 'alias_name' => 'address_line_2'],
        ['name' => 'city'],
        ['name' => 'state'],
        ['name' => 'postalCode', 'alias_name' => 'post_code'],
        ['name' => 'country'],
        ['name' => 'salesRepEmployeeNumber', 'alias_name' => 'sales_rep_employee_number'],
        ['name' => 'creditLimit', 'alias_name' => 'credit_limit'],
    ]
]);


$query = $parser->parse(true);
$result = $client['send']($url, $query, true);

echo '<pre>';

#var_dump($result);
foreach ($result as $customerData) {
    print_r($customerData);
    echo '<br />';
}