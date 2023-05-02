<?php

namespace App\Controller;

use App\Service\SalesProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/salesProduct")
 */
class SalesProductController extends BaseController
{

    /**
     * @Route("/salesProduct", name="app_salesProduct_list", methods={"GET"})
     */
    public function salesProduct_list(Request $request, ValidatorInterface $validator, SalesProductService $salesProduct_service): JsonResponse
    {
        try {
            $list_salesProduct = $salesProduct_service->list_salesProduct();
            return $this->respuesta(200, $list_salesProduct, []);
        } catch (\Throwable $th) {
            //$log::get_log()->error('ENDPOINT: registrar_email ERROR: ' . $th->getMessage());
            return $this->respuesta(400, [], ['Ocurrió un error al obtener los productos.'], 400);
        }
        // $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.');
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }
}
