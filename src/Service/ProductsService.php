<?php

namespace App\Service;

use App\Repository\ProductsRepository;

class ProductsService
{
    protected $rep_products;

    public function __construct(ProductsRepository $rep_products)
    {
        $this->rep_products = $rep_products;
    }

    public function list_products()
    {
        return $this->rep_products->list_products();
    }
}