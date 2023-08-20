<?php

namespace App\DTO\Reportes;


class ReportIncomesExpensesDTO
{
    protected $incomes;
    protected $egress;
    protected $difference;


    public function __construct(float $incomes, float $expenses)
    {
        $this->incomes = $incomes;
        $this->egress = $expenses;
    }

    public function to_array(): array
    {
        $respuesta = [];
        $respuesta['incomes'] = $this->getIncomes();
        $respuesta['egress'] = $this->getEgress();
        $respuesta['diference'] = $this->getDifference();
        return $respuesta;
    }

    public function getIncomes(): float
    {
        return $this->incomes;
    }
    public function setIncomes(float $incomes): void
    {
        $this->incomes = $incomes;
    }

    public function getEgress(): float
    {
        return $this->egress;
    }
    public function setEgress(float $expenses): void
    {
        $this->egress = $expenses;
    }

    public function getDifference(): float
    {
        return $this->getIncomes() - $this->getEgress();
    }
}
