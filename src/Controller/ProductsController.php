<?php

namespace App\Controller;

use App\DTO\Products\AddProductDTO;
use App\DTO\Products\DeleteProductDTO;
use App\DTO\Products\DelProductDTO;
use App\DTO\Products\OneProductDTO;
use App\Form\Type\Productos\AddProductType;
use App\Form\Type\Productos\DeleteProductType;
use App\Form\Type\Productos\DelProductType;
use App\Form\Type\Productos\OneProductType;
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
     * @Route("/products", name="app_products_list", methods={"GET"})
     */
    public function list_products(Request $request, ValidatorInterface $validator, ProductsService $products_service): JsonResponse
    {
        try {
            $list_products = $products_service->list_products();
            return $this->respuesta(200, $list_products, []);
        } catch (\Throwable $th) {
            //$log::get_log()->error('ENDPOINT: registrar_email ERROR: ' . $th->getMessage());
            return $this->respuesta(400, [], ['Ocurrió un error al obtener los productos.'], 400);
        }
        // $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.');
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }

    /**
     * @Route("/products", name="app_products_add", methods={"POST"})
     */
    public function add_product(Request $request, ValidatorInterface $validator, ProductsService $products_service): JsonResponse
    {
        $this->request_to_json($request);
        $dto = new AddProductDTO();
        $form = $this->createForm(AddProductType::class, $dto);
        $form->handleRequest($request);

        $errores = $this->obtener_validaciones($validator, $dto);
        if (count($errores) > 0) {
            //$this->errores_to_log($errores, $log, 'app_agregar_productos');
            return $this->respuesta(400, [], $errores, 400);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $resultado = $products_service->add_product($dto);
                if ($resultado !== true) {
                    //$log::get_log()->error('ENDPOINT: app_agregar_productos ERROR: Ocurrió un error grabando el asegurado.');
                    throw new \Exception("Ocurrió un error al agregar el producto.");
                }
                $respuesta = [
                    'OK' => 'OK'
                ];
                return $this->respuesta(200, $respuesta, []);
            } catch (\Throwable $th) {
                //$log::get_log()->error('ENDPOINT: app_agregar_productos ERROR: ' . $th->getMessage());
                return $this->respuesta(400, [], [$th->getMessage()], 400);
            }
        }
        // $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.');
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }

    /**
     * @Route("/products/delete", name="app_products_del", methods={"POST"})
     */
    public function delete_product(Request $request, ValidatorInterface $validator, ProductsService $products_service): JsonResponse
    {
        $this->request_to_json($request);
        $dto = new DeleteProductDTO();
        $form = $this->createForm(DeleteProductType::class, $dto);
        $form->handleRequest($request);
        $errores = $this->obtener_validaciones($validator, $dto);
        if (count($errores) > 0) {
            //$this->errores_to_log($errores, $log, 'app_agregar_productos');
            return $this->respuesta(400, [], $errores, 400);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $resultado = $products_service->del_product($dto);
                if ($resultado !== true) {
                    //$log::get_log()->error('ENDPOINT: app_agregar_productos ERROR: Ocurrió un error grabando el asegurado.');
                    throw new \Exception("Ocurrió un error al agregar el producto.");
                }
                $respuesta = [
                    'OK' => 'OK'
                ];
                return $this->respuesta(200, $respuesta, []);
            } catch (\Throwable $th) {
                //$log::get_log()->error('ENDPOINT: app_agregar_productos ERROR: ' . $th->getMessage());
                return $this->respuesta(400, [], [$th->getMessage()], 400);
            }
        }
        // $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.');
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }

    /**
     * @Route("/products/{code}", name="app_products_get_one", methods={"GET"})
     */
    public function one_product(ValidatorInterface $validator, ProductsService $products_service, $code): JsonResponse
    {
        $dto = new OneProductDTO();
        $form = $this->createForm(OneProductType::class, $dto);
        $dto->setCode($code);
        $errores = $this->obtener_validaciones($validator, $dto);
        if (count($errores) > 0) {
            //$this->errores_to_log($errores, $log, 'app_agregar_productos');
            return $this->respuesta(400, [], $errores, 400);
        }

        try {
            $resultado = $products_service->one_product($dto);
            if ($resultado === null) {
                //$log::get_log()->error('ENDPOINT: app_agregar_productos ERROR: Ocurrió un error grabando el asegurado.');
                throw new \Exception("Ocurrió un error al buscar el producto.");
            }
            $respuesta = [
                'OK' => 'OK',
                'product' => $resultado
            ];
            return $this->respuesta(200, $respuesta, []);
        } catch (\Throwable $th) {
            //$log::get_log()->error('ENDPOINT: app_agregar_productos ERROR: ' . $th->getMessage());
            return $this->respuesta(400, [], [$th->getMessage()], 400);
        }

        // $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.');
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }

    /**
     * @Route("/products/price_percent/{percentage}", name="app_products_price_percent", methods={"GET"})
     */
    public function percentage_price_product(ValidatorInterface $validator, ProductsService $products_service, $percentage): JsonResponse
    {
        if ($percentage === null) {
            //$this->errores_to_log($errores, $log, 'app_agregar_productos');
            return $this->respuesta(400, [], [], 400);
        }

        try {
            $resultado = $products_service->products_price_percentage($percentage);
            if ($resultado !== true) {
                //$log::get_log()->error('ENDPOINT: app_agregar_productos ERROR: Ocurrió un error grabando el asegurado.');
                throw new \Exception("Ocurrió un error al buscar el producto.");
            }
            $respuesta = [
                'OK' => 'OK',
            ];
            return $this->respuesta(200, $respuesta, []);
        } catch (\Throwable $th) {
            //$log::get_log()->error('ENDPOINT: app_agregar_productos ERROR: ' . $th->getMessage());
            return $this->respuesta(400, [], [$th->getMessage()], 400);
        }

        // $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.');
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }
}
