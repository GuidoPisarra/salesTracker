<?php

namespace App\Repository;

use App\DTO\Products\ProductDTO;
use PDO;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Model\Product;


class ProductsRepository extends BaseRepository
{

    public function list_products(): ?array
    {
        $query = $this->get_bbdd()->prepare('SELECT id id, description description,cost_price cost_price,sale_price sale_price,quantity quantity,id_proveedor id_proveedor,code code,size size,activo activo FROM product WHERE  activo = :activo');

        $activo = 0;
        $query->bindParam(':activo', $activo);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $products = $query->fetchAll();

        if (!$products) {
            return null;
        }

        return $products;
    }
}
