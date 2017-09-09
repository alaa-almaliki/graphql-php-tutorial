<?php

abstract class Data
{
    private $resource;
    private $data = [];

    public $id;

    abstract public function getTable();

    public function __construct()
    {
        $this->resource = new Resource();
        $this->resource->getConnection()->setTable($this->getTable());
    }

    public function getById($id)
    {
        $this->getByField('id', $id);
        return $this;
    }

    public function getByField($fieldName, $value)
    {
        $this->data = $this->resource->getConnection()->get($fieldName, $value);
        $this->assignVars();
        $this->setIdField();
        return $this;
    }

    public function getAll()
    {
        $data = $this->resource->getConnection()->getAll();
        $customers = [];
        foreach ($data as $datum) {
            $customer = new static();
            $customer->assignLoadedData($datum);
            $customer->assignVars();
            $customers[] = $customer;
        }
        return $customers;
    }

    private function assignLoadedData(array $data)
    {
        $this->data = $data;
        $this->assignVars();
        return $this;
    }

    private function assignVars()
    {
        foreach ($this->data as $key => $val) {
            $parts = array_map(function ($word) {
                return ucfirst($word);
            }, explode('_', $key));

            $var = lcfirst(implode($parts));
            $this->$var = $val;
        }
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * @return $this
     */
    protected function setIdField()
    {
        // implement to assign the auto increment field to the $this->id field if it is a different name
        return $this;
    }
}