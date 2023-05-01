<?php

namespace App\DTO\Expenses;

use DateTime;
use Symfony\Component\Validator\Constraints\Date;

class AddExpenseDTO
{

    protected $description;
    protected $price;
    protected $id_sucursal;
    protected $dateExpense;

    public function to_array(): array
    {
        $resultado = [];
        $resultado['description'] = $this->getDescription();
        $resultado['price'] = $this->getPrice();
        $resultado['idSucursal'] = 1;
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $date = new DateTime();
        $date_string = $date->format('Y-m-d H:i:s');
        $resultado['dateExpense'] = $date_string;
        return $resultado;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setIdSucursal(int $idSucursal): void
    {
        $this->id_sucursal = $idSucursal;
    }

    public function getIdSucursal(): int
    {
        return $this->id_sucursal;
    }

    public function setDateExpense(string $date): void
    {
        $this->dateExpense = $date;
    }

    public function getDateExpense(): string
    {
        return $this->dateExpense;
    }
}
