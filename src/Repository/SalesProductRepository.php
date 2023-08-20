<?php

namespace App\Repository;

use App\DTO\SalesProduct\DeleteSalesProductDTO;
use App\DTO\SalesProduct\RegisterSalesProductDTO;
use PDO;

class SalesProductRepository extends BaseRepository
{
    public function list_salesProduct(): ?array
    {
        $query = $this->get_bbdd()->prepare('SELECT id id, description description,price price,id_sucursal id_sucursal, date_expense date_expense FROM expense');

        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $salesProduct = $query->fetchAll();

        if (!$salesProduct) {
            return null;
        }

        return $salesProduct;
    }

    public function save_salesProduct(array $datosDto): ?bool
    {
        //insertar en sales y quedarme con el primer id
        $id_sale = -1;
        $active = 0;
        $register = 0;
        $save_ok = true;
        foreach ($datosDto as $venta) {
            $newSale = $venta->to_array();

            $querySale = $this->get_bbdd()->prepare('INSERT INTO sales (id_product) VALUES (:idProduct)');
            $querySale->bindParam(':idProduct', $newSale["idProduct"]);
            $responseSale = $querySale->execute();
            //obtengo el ultimo id por unica vez, esto hay que mejorarlo
            if ($id_sale === -1) {
                $querySale = $this->get_bbdd()->prepare('SELECT id FROM sales ORDER BY id DESC LIMIT 1');
                $responseSale = $querySale->execute();
                $id_sale = $querySale->fetch(PDO::FETCH_ASSOC);
                $idSALE = $id_sale['id'];
            }

            $query = $this->get_bbdd()->prepare('INSERT INTO sales_product 
                (id_sale, id_product, quantity, price, sale_product_date, type_payment, active, register)
                VALUES (:idSale, :idProduct, :quantity, :price, :saleDay, :typePayment, :active, :register)');

            $query->bindParam(':idSale', $idSALE);
            $query->bindParam(':idProduct', $newSale["idProduct"]);
            $query->bindParam(':saleDay', $newSale["saleDay"]);
            $query->bindParam(':quantity', $newSale["quantity"]);
            $query->bindParam(':price', $newSale["price"]);
            $query->bindParam(':typePayment', $newSale["typePayment"]);
            $query->bindParam(':active', $active);
            $query->bindParam(':register', $register);

            $response = $query->execute();
            if (!$response || !$responseSale) {
                $save_ok = false;
            }
        }

        return $save_ok;
    }

    public function delete_salesProduct(DeleteSalesProductDTO $dto): ?bool
    {
        $deleteId = $dto->to_array();

        $query = $this->get_bbdd()->prepare('UPDATE sales_product SET active = 1 WHERE id_sale = :idSaleProduct');

        $query->bindParam(':idSaleProduct', $deleteId['idSaleProduct']);
        $delete = $query->execute();

        return $delete;
    }

    public function register_salesProduct(RegisterSalesProductDTO $dto): ?bool
    {
        $deleteId = $dto->to_array();

        $query = $this->get_bbdd()->prepare('UPDATE sales_product SET register = 1 WHERE id_sale = :idSaleProduct');

        $query->bindParam(':idSaleProduct', $deleteId['idSaleProduct']);
        $delete = $query->execute();

        return $delete;
    }
}
