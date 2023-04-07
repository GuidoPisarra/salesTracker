<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use App\Service\AppLogs;
use App\Service\ProductsService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/products")
 */
class ProductsController extends BaseController
{

    /**
     * @Route("/products", name="app_products", methods={"GET"})
     */
    public function registrar_usuario(Request $request, ValidatorInterface $validator, ProductsService $products_service): JsonResponse
    {

        try {
            $list_products = $products_service->list_products();
            //var_dump($list_products);
            $respuesta = [];
            //$this->request_to_json($list_products);
            return $this->respuesta(200, $list_products, []);
        } catch (\Throwable $th) {
            //$log::get_log()->error('ENDPOINT: registrar_email ERROR: ' . $th->getMessage());
            return $this->respuesta(400, [], ['Ocurrió un error al obtener los productos.'], 400);
        }


        // $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.');
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }
}
