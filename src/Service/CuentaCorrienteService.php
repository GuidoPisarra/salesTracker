<?php

namespace App\Service;

use App\Repository\CuentaCorrienteRepository;

class CuentaCorrienteService
{
    protected $rep_expense;

    public function __construct(CuentaCorrienteRepository $rep_expense)
    {
        $this->rep_expense = $rep_expense;
    }

    public function list_cuentas_corrientes(int $id_negocio)
    {
        return $this->rep_expense->list_cuentas_corrientes($id_negocio);
    }

    public function list_cuentas_corrientes_con_deuda(int $id_negocio)
    {
        return $this->rep_expense->list_cuentas_corrientes_con_deuda($id_negocio);
    }
}