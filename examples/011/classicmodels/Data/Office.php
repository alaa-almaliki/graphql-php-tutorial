<?php

class Office extends Data
{
    public $officeCode;
    public $city;
    public $phone;
    public $addressLine1;
    public $addressLine2;
    public $state;
    public $country;
    public $postalCode;
    public $territory;

    public function getTable()
    {
        return 'offices';
    }

    public function getById($id)
    {
        return $this->getByField('officeCode', $id);
    }

    protected function setIdField()
    {
        $this->id = $this->officeCode;
        return $this;
    }
}