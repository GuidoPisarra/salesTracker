<?php

namespace App\Repository;


use PDO;

class CuentaCorrienteRepository extends BaseRepository
{

    public function list_cuentas_corrientes(int $id_negocio): ?array
    {
        $idNegocio = $id_negocio;
        $query = $this->get_bbdd()->prepare('SELECT clientes.*               
            FROM clientes
            WHERE clientes.id_negocio = :id_negocio');
        $query->bindParam(':id_negocio', $idNegocio);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $expenses = $query->fetchAll();

        if (!$expenses) {
            return null;
        }

        return $expenses;
    }

    public function list_cuentas_corrientes_con_deuda(int $id_negocio): ?array
    {
        $idNegocio = $id_negocio;
        $query = $this->get_bbdd()->prepare('SELECT clientes.*, 
                (
                SELECT SUM(pago.entrega) FROM saleTrackerTEST.ctacte cuentaDeuda
                INNER JOIN saleTrackerTEST.pagos pago ON pago.id_ctacte = cuentaDeuda.id
                ) as pagos,
                (
                SELECT SUM(cta.precio_original) FROM saleTrackerTEST.ctacte cta 
                INNER JOIN saleTrackerTEST.clientes c ON c.id = cta.id_persona
                ) as deuda
            FROM (
                SELECT MIN(clientes.id) AS cliente_id, clientes.dni
                FROM saleTrackerTEST.clientes clientes
                INNER JOIN saleTrackerTEST.ctacte cuenta ON clientes.id = cuenta.id_persona
                WHERE clientes.id_negocio = :id_negocio
                GROUP BY clientes.dni
            ) AS clientesUnicos
            INNER JOIN saleTrackerTEST.clientes clientes ON clientesUnicos.cliente_id = clientes.id
            INNER JOIN saleTrackerTEST.ctacte cuenta ON clientes.id = cuenta.id_persona 

            WHERE clientes.id_negocio = :id_negocio1
            GROUP BY clientes.dni
            HAVING deuda> ifnull(pagos,0)');
        $query->bindParam(':id_negocio', $idNegocio);
        $query->bindParam(':id_negocio1', $idNegocio);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $expenses = $query->fetchAll();

        if (!$expenses) {
            return null;
        }

        return $expenses;
    }

    public function add_agregar_venta_cuenta_corriente()
    {
    }
}
