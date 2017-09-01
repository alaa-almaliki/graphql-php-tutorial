<?php
$client = include_once '../client.php';

$url = 'http://development.local/graphql/examples/007/graphql.php';

$parser = new \GraphQL\Client\Query\Parser();
$parser->addFields([
    ['name' => 'user', 'args' => ['id' => 3]],
]);

$parser->addChildField('user', 'id');
//$parser->addChildField('user', 'firstName');
//$parser->addChildField('user', 'lastName');
//$parser->addChildField('user', 'email');
//$parser->addChildField('user', 'phoneNumber');

$parser->addFragment(
    [
        'field' => 'user', // the field user
        'name' => 'requiredFields', // fragment name
        'type' => 'User', // type name  = query type
        'fields' => [ // fields are included in the fragment
            'firstName',
            'lastName',
            'email',
            'phoneNumber'
        ]
    ]
);

$query = $parser->parse(); // {"query": "query { user( id: 3 ){ id, ...requiredFields} } fragment requiredFields on User { firstName lastName email phoneNumber } "}


$result = $client['send']($url, $query, true);

echo '<pr />';
echo implode('<br />', $result['data']['user']);