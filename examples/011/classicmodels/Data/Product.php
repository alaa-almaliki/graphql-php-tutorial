<?php

class Product extends Data
{
    public $productCode;
    public $productLine;
    public $productScale;
    public $productVendor;
    public $productDescription;
    public $quantityInStock;
    public $buyPrice;
    public $MSRP;

    public function getTable()
    {
        return 'products';
    }

    public function getByCode($id)
    {
        return $this->getByField('productCode', $id);
    }
}