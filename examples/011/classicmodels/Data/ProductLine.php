<?php

class ProductLine extends Data
{
    public $productLine;
    public $textDescription;
    public $htmlDescription;
    public $image;

    public function getTable()
    {
        return 'productlines';
    }


    public function getByProductLine($id)
    {
        return $this->getByField('productLine', $id);
    }

}