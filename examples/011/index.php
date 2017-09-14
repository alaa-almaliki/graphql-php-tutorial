<?php
require_once  './includes.php';

$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/011/graphql.php';


$parser = new \GraphQL\Client\Query\Parser();
$queryBuilder = $parser->createQueryBuilder('graqhql');

$queryBuilder->addFields(
    [
        [
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
                [
                    'name' => 'payment',
                    'fields' => [
                        ['name' => 'customerNumber'],
                        ['name' => 'checkNumber'],
                        ['name' => 'paymentDate'],
                        ['name' => 'amount'],
                    ]
                ]
            ]
        ],
        [
            'name' => 'employee',
            'arguments' => [
                [
                    'name' => 'id',
                    'value' => 1002,
                ]
            ],
            'fields' => [
                ['name' => 'id'],
                ['name' => 'employeeNumber', 'alias_name' => 'employee_number'],
                ['name' => 'lastName', 'alias_name' => 'last_name'],
                ['name' => 'firstName', 'alias_name' => 'first_name'],
                ['name' => 'extension'],
                ['name' => 'email'],
                ['name' => 'officeCode', 'alias_name' => 'office_code'],
                ['name' => 'reportsTo', 'alias_name' => 'report_to'],
                ['name' => 'jobTitle',  'alias_name' => 'job_title'],
                [
                    'name' => 'office',
                    'fields' => [
                        ['name' => 'officeCode'],
                        ['name' => 'city'],
                        ['name' => 'phone'],
                        ['name' => 'addressLine1'],
                        ['name' => 'addressLine2'],
                        ['name' => 'state'],
                        ['name' => 'country'],
                        ['name' => 'postalCode'],
                        ['name' => 'territory'],
                    ]
                ]
            ],
        ],
        [
            'name' => 'order',
            'arguments' => [
                [
                    'name' => 'id',
                    'value' => 10100,
                ]
            ],
            'fields' => [
                ['name' => 'id'],
                ['name' => 'orderNumber'],
                ['name' => 'orderDate'],
                ['name' => 'requiredDate'],
                ['name' => 'shippedDate'],
                ['name' => 'status'],
                ['name' => 'comments'],
                ['name' => 'customerNumber'],
                [
                    'name' => 'customer',
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
                ],
                [
                    'name' => 'orderDetails',
                    'fields' => [
                        ['name' => 'id'],
                        ['name' => 'orderNumber'],
                        ['name' => 'productCode'],
                        ['name' => 'quantityOrdered'],
                        ['name' => 'priceEach'],
                        ['name' => 'orderLineNumber'],
                    ]
                ]
            ]
        ],
        [
            'name' => 'productLine',
            'arguments' => [
                [
                    'name' => 'productLine',
                    'value' => 'Trains'
                ]
            ],
            'fields' => [
                ['name' => 'productLine'],
                ['name' => 'textDescription'],
                ['name' => 'htmlDescription'],
                ['name' => 'image'],
            ]
        ]
    ]
);





$query = $parser->parse(true);

$result = $client['send']($url, $query, true);

echo '<pre>';

//print_r($result);
foreach ($result as $customerData) {
    print_r($customerData);
    echo '<br />';
}