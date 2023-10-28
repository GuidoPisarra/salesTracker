<?php

namespace App\Controller;

use App\DTO\CuentaCorriente\NuevaVentaCtaCteDTO;
use App\Form\Type\CuentaCorriente\NuevaVentaCtaCteType;
use App\Service\CuentaCorrienteService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/cuenta_corriente")
 */
class CuentaCorrienteController extends BaseController
{

    /**
     * @Route("/obtener_cuentas_corrientes/{id_negocio}", name="app_obtener_cuentas_corrientes", methods={"GET"})
     */
    public function cuentas_list(Request $request, ValidatorInterface $validator, CuentaCorrienteService $service, int $id_negocio): JsonResponse
    {
        try {
            $list_cuentas_corrientes = $service->list_cuentas_corrientes($id_negocio);
            return $this->respuesta(200, $list_cuentas_corrientes, []);
        } catch (\Throwable $th) {
            //$log::get_log()->error('ENDPOINT: registrar_email ERROR: ' . $th->getMessage());
            return $this->respuesta(400, [], ['Ocurrió un error al obtener los productos.'], 400);
        }
        // $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.');
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }

    /**
     * @Route("/obtener_cuentas_corrientes_con_deuda/{id_negocio}", name="app_obtener_cuentas_corrientes_con_deuda", methods={"GET"})
     */
    public function cuentass_list_con_deuda(Request $request, ValidatorInterface $validator, CuentaCorrienteService $service, int $id_negocio): JsonResponse
    {
        try {
            $list_cuentas_corrientes = $service->list_cuentas_corrientes_con_deuda($id_negocio);
            return $this->respuesta(200, $list_cuentas_corrientes, []);
        } catch (\Throwable $th) {
            //$log::get_log()->error('ENDPOINT: registrar_email ERROR: ' . $th->getMessage());
            return $this->respuesta(400, [], ['Ocurrió un error al obtener los productos.'], 400);
        }
        // $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.');
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }

    /**
     * @Route("/agregar_venta_cuenta_corriente", name="app_agregar_venta_cuenta_corriente", methods={"POST"})
     */
    public function add_agregar_venta_cuenta_corriente(Request $request, ValidatorInterface $validator, CuentaCorrienteService $service): JsonResponse
    {
        $this->request_to_json($request);
        $dto = new NuevaVentaCtaCteDTO();
        $form = $this->createForm(NuevaVentaCtaCteType::class, $dto);
        $form->handleRequest($request);

        $errores = $this->obtener_validaciones($validator, $dto);
        if (count($errores) > 0) {
            //$this->errores_to_log($errores, $log, 'app_agregar_productos');
            return $this->respuesta(400, [], $errores, 400);
        }

        try {
             $resultado = $service->add_agregar_venta_cuenta_corriente($dto);
            if ($resultado !== true) {
                //$log::get_log()->error('ENDPOINT: app_agregar_gastos ERROR: Ocurrió un error grabando el gasto.');
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

        // $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.');
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }
}