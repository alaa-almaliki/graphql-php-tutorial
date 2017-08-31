<?php

class User
{
    private $resource;
    private $data = [];

    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $phoneNumber;


    public function __construct()
    {
        $this->resource = new Resource();
        $this->resource->getConnection()->setTable('user');
    }

    public function getById($id)
    {
        $this->getByField('id', $id);
        return $this;
    }

    private function getByField($fieldName, $value)
    {
        $this->data = $this->resource->getConnection()->get($fieldName, $value);
        foreach ($this->data as $key => $val) {
            $parts = array_map(function ($word) {
                return ucfirst($word);
            }, explode('_', $key));

            $var = lcfirst(implode($parts));
            $this->$var = $val;
        }
        return $this;
    }
}