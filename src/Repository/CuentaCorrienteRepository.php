<?php

namespace App\Repository;


use PDO;

class CuentaCorrienteRepository extends BaseRepository
{

    public function list_cuentas_corrientes(int $id_negocio): ?array
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
        /*  $query = $this->get_bbdd()->prepare('SELECT 
            venta_productos.id_sales_product id_venta_producto,
            venta_productos.id_sale id_venta,
            venta_productos.quantity cantidad_producto_vendido,
            venta_productos.price precio_venta_original,
            venta_productos.sale_product_date fecha_venta,
            venta_productos.id_negocio id_negocio_venta,
            negocio.nombre nombre_negocio_venta,
            negocio.domicilio sucursal_venta,
            venta_productos.sucursal sucursal_venta,
            cliente.id idCliente,
            cliente.dni dni_cliente,
            cliente.apellido apellido_cliente,
            cliente.nombre nombre_cliente,
            cliente.telefono telefono_cliente,
            producto.id id_producto,
            producto.description description_producto,
            producto.size detalle_producto,    
            cuenta.precio_original precio_original_cuenta,
            cuenta.precio_actual precio_actual_cuenta,
            pagos.entrega  entrega_pago, 
            pagos.fecha  fecha_pago 
        FROM saleTrackerTEST.ctacte cuenta
        INNER JOIN saleTrackerTEST.clientes cliente ON cliente.id = cuenta.id_persona
        INNER JOIN saleTrackerTEST.sales_product venta_productos ON venta_productos.id_sales_product = cuenta.id_sale_product
        INNER JOIN saleTrackerTEST.product producto ON venta_productos.id_product = producto.id
        LEFT JOIN saleTrackerTEST.pagos pagos ON pagos.id_ctacte = cuenta.id
        INNER JOIN saleTrackerTEST.negocio negocio ON venta_productos.id_negocio=negocio.id AND venta_productos.sucursal=negocio.sucursal
        WHERE negocio.id = :id_negocio
        ORDER BY cliente.id, venta_productos.sale_product_date ASC'); */
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
}