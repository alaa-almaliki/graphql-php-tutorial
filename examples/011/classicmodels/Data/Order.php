<?php

class Order extends Data
{
    public $orderNumber;
    public $orderDate;
    public $requiredDate;
    public $shippedDate;
    public $status;
    public $comments;
    public $customerNumber;

    public function getTable()
    {
        return 'orders';
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