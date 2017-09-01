<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/006/graphql.php';

$parser = new \GraphQL\Client\Query\Parser();
$parser->addFields([
    ['name' => 'user', 'args' => ['id' => 3]],
]);

$parser->addChildField('user', 'id');
$parser->addChildField('user', 'firstName');
$parser->addChildField('user', 'lastName');
$parser->addChildField('user', 'email');
$parser->addChildField('user', 'phoneNumber');


$query = $parser->parse();


$result = $client['send']($url, $query, true);

echo '<pr />';
echo implode('<br />', $result['data']['user']);