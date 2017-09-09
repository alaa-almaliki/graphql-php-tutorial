<?php
require_once './../../vendor/autoload.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/Validation/Email.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/ValidatorInterface.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/AbstractType.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/EmailType.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/Registry.php';

require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'data/Connection.php';
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'data/Resource.php';
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'data/Data.php';
require_once __DIR__ . '/classicmodels/Type/NodeType.php';
require_once __DIR__ . '/classicmodels/Data/Employee.php';
require_once __DIR__ . '/classicmodels/Type/EmployeeType.php';
require_once __DIR__ . '/classicmodels/Data/Customer.php';
require_once __DIR__ . '/classicmodels/Type/CustomerType.php';
require_once __DIR__ . '/classicmodels/Type/QueryType.php';
require_once __DIR__ . '/classicmodels/Types.php';

