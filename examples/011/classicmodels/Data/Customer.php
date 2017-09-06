<?php

/**
 * Class Customer
 */
class Customer extends Data
{
    public $customerNumber;
    public $customerName;
    public $contactLastName;
    public $contactFirstName;
    public $phone;
    public $addressLine1;
    public $addressLine2;
    public $city;
    public $state;
    public $postalCode;
    public $country;
    public $salesRepEmployeeNumber;
    public $creditLimit;

    public function getTable()
    {
        return 'customers';
    }

   public function getById($id)
   {
       return $this->getByField('customerNumber', $id);
   }
}