<?php

namespace App\Repository;

use PDO;

class SalesProductRepository extends BaseRepository
{

    public function list_salesProduct(): ?array
    {
        $query = $this->get_bbdd()->prepare('SELECT id id, description description,price price,id_sucursal id_sucursal, date_expense date_expense FROM expense');

        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $expenses = $query->fetchAll();

        if (!$expenses) {
            return null;
        }

        return $expenses;
    }
}
