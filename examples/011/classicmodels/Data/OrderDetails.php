<?php

class OrderDetails extends Data
{
    public $orderNumber;
    public $productCode;
    public $quantityOrdered;
    public $priceEach;
    public $orderLineNumber;

    public function getTable()
    {
        return 'orderdetails';
    }

    public function getById($id)
    {
        return $this->getByField('orderNumber', $id);
    }

    protected function setIdField()
    {
        $this->id = $this->orderNumber;
        return $this;
    }
}