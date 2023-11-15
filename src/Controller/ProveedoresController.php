<?php

namespace App\Controller;

use App\Service\ProveedoresService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/proveedores")
 */
class ProveedoresController extends BaseController
{
    /**
     * @Route("/proveedores_list/{id_local}", name="app_proveedores_list", methods={"GET"})
     */
    public function list_proveedores(Request $request, ValidatorInterface $validator, ProveedoresService $proveedores_service, int $id_local): JsonResponse
    {
        try {
            $a = $id_local;
            $list_products = $proveedores_service->list_proveedores($id_local);
            return $this->respuesta(200, $list_products, []);
        } catch (\Throwable $th) {
            //$log::get_log()->error('ENDPOINT: registrar_email ERROR: ' . $th->getMessage());
            return $this->respuesta(400, [], ['Ocurrió un error al obtener los productos.'], 400);
        }
        // $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.');
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }
}
