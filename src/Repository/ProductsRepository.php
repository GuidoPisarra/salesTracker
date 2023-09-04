<?php

namespace App\Repository;

use App\DTO\Products\AddProductDTO;
use App\DTO\Products\AddStockDTO;
use App\DTO\Products\DeleteProductDTO;
use App\DTO\Products\OneProductDTO;
use App\DTO\Products\ProductDTO;
use PDO;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Model\Product;


class ProductsRepository extends BaseRepository
{

    public function list_products(int $id_local): ?array
    {
        $query = $this->get_bbdd()->prepare('SELECT id id, description description,cost_price cost_price,sale_price sale_price,quantity quantity,id_proveedor id_proveedor,code code,size size,activo activo FROM product WHERE  activo = :activo AND id_negocio = :local');

        $activo = 0;
        $query->bindParam(':activo', $activo);
        $query->bindParam(':local', $id_local);

        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $products = $query->fetchAll();

        if (!$products) {
            return null;
        }

        return $products;
    }

    public function add_product(AddProductDTO $dto): bool
    {

        $query = $this->get_bbdd()->prepare('INSERT INTO product 
        (description, cost_price, sale_price, quantity, id_proveedor, code, size, activo, id_negocio)
        VALUES (:description, :costPrice, :salePrice, :quantity, :idProveedor, :code, :size, :activo, :id_negocio)');

        $newProduct = $dto->to_array();
        $activo = 0;
        $query->bindParam(':description', $newProduct["description"]);
        $query->bindParam(':costPrice', $newProduct["costPrice"]);
        $query->bindParam(':salePrice', $newProduct["salePrice"]);
        $query->bindParam(':quantity', $newProduct["quantity"]);
        $query->bindParam(':idProveedor', $newProduct["idProveedor"]);
        $query->bindParam(':code', $newProduct["code"]);
        $query->bindParam(':size', $newProduct["size"]);
        $query->bindParam(':activo', $activo);
        $query->bindParam(':id_negocio', $newProduct["id_negocio"]);

        $response = $query->execute();
        return $response;
    }

    public function del_product(DeleteProductDTO $dto): bool
    {
        $query = $this->get_bbdd()->prepare('DELETE  FROM product WHERE id = :id');

        $newProduct = $dto->to_array();
        $query->bindParam(':id', $newProduct["id"]);


        $response = $query->execute();
        return $response;
    }

    public function one_product(OneProductDTO $dto): array
    {
        $query = $this->get_bbdd()->prepare('SELECT id id, description description,cost_price cost_price,sale_price sale_price,quantity quantity,id_proveedor id_proveedor,code code,size size,activo activo FROM product WHERE  code = :code AND activo=0 AND id_negocio = :id_negocio');

        $newProduct = $dto->to_array();
        $query->bindParam(':code', $newProduct["code"]);
        $query->bindParam(':id_negocio', $newProduct["id_negocio"]);

        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $product = $query->fetch();

        return $product;
    }

    public function products_price_percentage(float $percentage, int $id_negocio): bool
    {
        $percent = (float) $percentage;
        $negocio = $id_negocio;
        $query = $this->get_bbdd()->prepare('UPDATE product p SET p.sale_price =CEIL( p.sale_price +((p.sale_price  * :percent )/100)) WHERE p.activo = 0 AND id_negocio = :id_negocio');

        $query->bindParam(':percent', $percent);
        $query->bindParam(':id_negocio', $negocio);
        $response = $query->execute();


        return $response;
    }

    public function add_products_stcok(AddStockDTO $dto): bool
    {
        $query = $this->get_bbdd()->prepare('UPDATE product p SET p.quantity = p.quantity + :quantity WHERE p.id = :id AND p.activo = 0');

        $newProduct = $dto->to_array();
        $activo = 0;
        $query->bindParam(':id', $newProduct["id"]);
        $query->bindParam(':quantity', $newProduct["quantity"]);

        $response = $query->execute();
        return $response;
    }
}
