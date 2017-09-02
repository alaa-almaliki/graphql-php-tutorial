<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/006/graphql.php';

$parser = new \GraphQL\Client\Query\Parser();
$queryBuilder = $parser->createQueryBuilder('person');

$queryBuilder->addFields([
    ['name' => 'user', 'args' => ['id' => 3]],
]);

$queryBuilder->addChildField('user', 'id');
$queryBuilder->addChildField('user', 'firstName');
$queryBuilder->addChildField('user', 'lastName');
$queryBuilder->addChildField('user', 'email');
$queryBuilder->addChildField('user', 'phoneNumber');


$query = $parser->parse(true); // {"query":"query person { user( id: 3 ){ id, firstName, lastName, email, phoneNumber, } } "}


$result = $client['send']($url, $query, true);

echo '<pr />';
echo implode('<br />', $result['data']['user']);