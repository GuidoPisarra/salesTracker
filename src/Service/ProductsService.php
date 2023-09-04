<?php

namespace App\Service;

use App\DTO\Products\AddProductDTO;
use App\DTO\Products\AddStockDTO;
use App\DTO\Products\DeleteProductDTO;
use App\DTO\Products\OneProductDTO;
use App\Repository\ProductsRepository;

class ProductsService
{
    protected $rep_products;

    public function __construct(ProductsRepository $rep_products)
    {
        $this->rep_products = $rep_products;
    }

    public function list_products(int $id_local)
    {
        return $this->rep_products->list_products($id_local);
    }

    public function add_product(AddProductDTO $dto)
    {
        return $this->rep_products->add_product($dto);
    }

    public function del_product(DeleteProductDTO $dto)
    {
        return $this->rep_products->del_product($dto);
    }

    public function one_product(OneProductDTO $dto)
    {
        $dto->setCode(str_replace(';', '-', $dto->getCode()));
        return $this->rep_products->one_product($dto);
    }

    public function products_price_percentage(float $percentage, int $id_negocio)
    {
        return $this->rep_products->products_price_percentage($percentage, $id_negocio);
    }

    public function add_stock_product(AddStockDTO $dto)
    {
        return $this->rep_products->add_products_stcok($dto);
    }
}
