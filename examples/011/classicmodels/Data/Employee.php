<?php

class Employee extends Data
{
    public $employeeNumber;
    public $lastName;
    public $firstName;
    public $extension;
    public $email;
    public $officeCode;
    public $reportsTo;
    public $jobTitle;

    public function getTable()
    {
        return 'employees';
    }

    public function getById($id)
    {
        return $this->getByField('employeeNumber', $id);
    }

    protected function setIdField()
    {
        $this->id = $this->employeeNumber;
        //$this->email = 'alaa.almaliki@gmail.com';
        return $this;
    }
}