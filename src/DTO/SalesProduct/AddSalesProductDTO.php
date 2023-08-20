<?php

namespace App\DTO\SalesProduct;


class AddSalesProductDTO
{
    protected $idProduct;
    protected $saleDay;
    protected $quantity;
    protected $price;
    protected $typePayment;


    public function to_array(): array
    {
        $resultado = [];
        $resultado['idProduct'] = $this->getIdProduct();
        $resultado['saleDay'] = $this->getSaleDay();
        $resultado['quantity'] = $this->getQuantity();
        $resultado['price'] = $this->getPrice();
        $resultado['typePayment'] = $this->getTypePayment();

        return $resultado;
    }

    public function setIdProduct(int $idProduct): void
    {
        $this->idProduct = $idProduct;
    }

    public function getIdProduct(): int
    {
        return $this->idProduct;
    }

    public function setSaleDay(string $saleDay): void
    {
        $this->saleDay = $saleDay;
    }

    public function getSaleDay(): string
    {
        return $this->saleDay;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setTypePayment(string $typePayment): void
    {
        $this->typePayment = $typePayment;
    }

    public function getTypePayment(): string
    {
        return $this->typePayment;
    }
}
