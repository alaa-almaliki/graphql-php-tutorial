<?php

class Payment extends Data
{
    public $customerNumber;
    public $checkNumber;
    public $paymentDate;
    public $amount;

    public function getTable()
    {
        return 'payments';
    }

    public function getByCustomer($id)
    {
        return $this->getByField('customerNumber', $id);
    }

    public function getByCheck($id)
    {
        return $this->getByField('checkNumber', $id);
    }
}