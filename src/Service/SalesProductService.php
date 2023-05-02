<?php

namespace App\Service;

use App\Repository\SalesProductRepository;

class SalesProductService
{
    protected $rep_salesProduct;

    public function __construct(SalesProductRepository $rep_salesProduct)
    {
        $this->rep_salesProduct = $rep_salesProduct;
    }

    public function list_salesProduct()
    {
        return $this->rep_salesProduct->list_salesProduct();
    }
}
