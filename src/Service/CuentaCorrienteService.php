<?php

namespace App\Service;

use App\DTO\CuentaCorriente\NuevaVentaCtaCteDTO;
use App\DTO\SalesProduct\AddSalesProductDTO;
use App\Repository\CuentaCorrienteRepository;

class CuentaCorrienteService
{
    protected $rep_cta_cte;
    protected $service_sales_product;

    public function __construct(CuentaCorrienteRepository $rep_cta_cte, SalesProductService $service_sales_product)
    {
        $this->rep_cta_cte = $rep_cta_cte;
        $this->service_sales_product = $service_sales_product;
    }

    public function list_cuentas_corrientes(int $id_negocio)
    {
        return $this->rep_cta_cte->list_cuentas_corrientes($id_negocio);
    }

    public function list_cuentas_corrientes_con_deuda(int $id_negocio)
    {
        return $this->rep_cta_cte->list_cuentas_corrientes_con_deuda($id_negocio);
    }

    public function add_agregar_venta_cuenta_corriente(NuevaVentaCtaCteDTO $dto)
    {
        $datosDto = [];
        $lista_ventas = $dto->getVenta();
        $cliente = $dto->getCliente();
        $zonaHorariaArgentina = new \DateTimeZone('America/Argentina/Buenos_Aires');
        $fechaArgentina = new \DateTime('now', $zonaHorariaArgentina);
        $fechaFormateada = $fechaArgentina->format('Y-m-d H:m:s');
        foreach ($lista_ventas as $venta) {
            $dto = new AddSalesProductDTO();
            $dto->setIdProduct($venta->getIdProduct());
            $dto->setSaleDay($fechaFormateada);
            $dto->setPrice($venta->getPrice());
            $dto->setQuantity($venta->getQuantity());
            $dto->setTypePayment($venta->getTypePayment());
            $dto->setIdNegocio($venta->getNegocio());
            $dto->setSucursal($venta->getSucursal());
            $dto->setIdPersona($cliente->getId());
            array_push($datosDto, $dto);
        }
        //$this->rep_cta_cte->add_agregar_venta_cuenta_corriente();
        //$b = $datosDto;
        return $this->service_sales_product->save_salesProduct($datosDto);
    }
}
