<?php

namespace App\Repository;

use PDO;

class ProveedoresRepository extends BaseRepository
{

    public function list_proveedores(int $id_local): ?array
    {
        $query = $this->get_bbdd()->prepare('SELECT p.id AS id, p.nombre AS nombre
        FROM proveedores p
        WHERE p.id_negocio = :local 
        ORDER BY p.nombre ASC ');

        $activo = 0;
        $query->bindParam(':local', $id_local);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $proveedores = $query->fetchAll();

        if (!$proveedores) {
            return null;
        }

        return $proveedores;
    }
}
