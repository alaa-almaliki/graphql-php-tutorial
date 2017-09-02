<?php

class User extends Data
{
    public $firstName;
    public $lastName;
    public $email;
    public $phoneNumber;

    public function getTable()
    {
        return 'user';
    }

}