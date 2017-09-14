<?php
require_once './../../vendor/autoload.php';
require_once './../../src/GraphQL/Custom/Scalar/Validation/Email/AbstractEmail.php';
require_once './../../src/GraphQL/Custom/Scalar/Validation/Email/BasicEmail.php';
require_once './../../src/GraphQL/Custom/Scalar/Validation/Email/StrictEmail.php';
require_once './../../src/GraphQL/Custom/Scalar/Validation/AbstractValidator.php';
require_once './../../src/GraphQL/Custom/Scalar/Validation/Traits/PhoneNumberTrait.php';
require_once './../../src/GraphQL/Custom/Scalar/Validation/Email.php';
require_once './../../src/GraphQL/Custom/Scalar/Validation/PhoneNumber.php';
require_once './../../src/GraphQL/Custom/Scalar/Validation/PhoneRegion.php';
require_once './../../src/GraphQL/Custom/Scalar/Validation.php';

require_once './../../src/GraphQL/Custom/Scalar/Types/TypeValidationInterface.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/TypeMessageInterface.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/TypeParamsInterface.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/AbstractType.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/BasicEmailType.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/StrictEmailType.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/PhoneNumberType.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/PhoneRegionType.php';
require_once './../../src/GraphQL/Custom/Scalar/Types/Registry.php';

require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'data/Connection.php';
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'data/Resource.php';
require_once  dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'data/Data.php';
require_once __DIR__ . '/classicmodels/Type/NodeType.php';
require_once __DIR__ . '/classicmodels/Data/Employee.php';
require_once __DIR__ . '/classicmodels/Type/EmployeeType.php';
require_once __DIR__ . '/classicmodels/Data/Customer.php';
require_once __DIR__ . '/classicmodels/Data/Office.php';
require_once __DIR__ . '/classicmodels/Data/Order.php';
require_once __DIR__ . '/classicmodels/Data/OrderDetails.php';
require_once __DIR__ . '/classicmodels/Data/Payment.php';
require_once __DIR__ . '/classicmodels/Type/CustomerType.php';
require_once __DIR__ . '/classicmodels/Type/OfficeType.php';
require_once __DIR__ . '/classicmodels/Type/OrderType.php';
require_once __DIR__ . '/classicmodels/Type/OrderDetailsType.php';
require_once __DIR__ . '/classicmodels/Type/PaymentType.php';
require_once __DIR__ . '/classicmodels/Type/QueryType.php';
require_once __DIR__ . '/classicmodels/Types.php';

