<?php

namespace App\Controller;

use App\DTO\Usuario\ControlVersionDTO;
use App\DTO\Usuario\CambiarPasswordDTO;
use App\DTO\Usuario\ConfirmarRecuperarPassword;
use App\DTO\Usuario\GrabarPasswordDTO;
use App\DTO\Usuario\GuardarTokenNotificacionesPushDTO;
use App\DTO\Usuario\PasswordProvisoriaDTO;
use App\DTO\Usuario\RegistrarEmailDTO;
use App\DTO\Usuario\ValidarEmailDTO;
use App\DTO\Usuario\RecuperarPasswordDTO;
use App\Form\Type\Usuario\CambiarPasswordType;
use App\Form\Type\Usuario\ConfirmarRecuperarPasswordType;
use App\Form\Type\Usuario\ControlVersionType;
use App\Form\Type\Usuario\GrabarPasswordType;
use App\Form\Type\Usuario\GuardarTokenNotificacionesPushType;
use App\Form\Type\Usuario\PasswordProvisoriaType;
use App\Form\Type\Usuario\RegistrarEmailType;
use App\Form\Type\Usuario\ValidarEmailType;
use App\Form\Type\Usuario\RecuperarPasswordType;
use App\Model\Usuario;
use App\Repository\UsuarioRepository;
use App\Service\AppLogs;
use App\Service\Emails;
use App\Service\ServicioUsuario;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/usuario")
 */
class UsuarioController extends BaseController
{
    /**
     * @Route("/login", name="app_login", methods={"POST"})
     * @param UserInterface $usuario
     * @param JWTTokenManagerInterface $jwt_manager
     * @return JsonResponse
     */
    public function login(Usuario $usuario, JWTTokenManagerInterface $jwt_manager): JsonResponse
    {
        $token = $jwt_manager->create($usuario);
        $respuesta = [
            'token' => $token
        ];
        return $this->respuesta(200, $respuesta, []);
    }

    /**
     * @Route("/registrar_email", name="app_registrar_email", methods={"POST"})
     */
    public function registrar_email(UsuarioRepository $rep_usuario, AppLogs $log, Request $request, Emails $emails, ValidatorInterface $validator, ServicioUsuario $servicio_usuario): JsonResponse
    {
        var_dump('llega');
        /*    $this->request_to_json($request);
        $dto = new RegistrarEmailDTO($rep_usuario);
        $form = $this->createForm(RegistrarEmailType::class, $dto);
        $form->handleRequest($request);

        $errores = $this->obtener_validaciones($validator, $dto);
        if (count($errores) > 0) {
            $this->errores_to_log($errores, $log, 'registrar_email');
            return $this->respuesta(400, [], $errores, 400);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $servicio_usuario->grabar_email($dto);
                $emails->verificacion_email($dto);
                $respuesta = [
                    'OK' => 'OK'
                ];
                return $this->respuesta(200, $respuesta, []);
            } catch (\Throwable $th) {
                $log::get_log()->error('ENDPOINT: registrar_email ERROR: ' . $th->getMessage());
                return $this->respuesta(400, [], ['Ocurrió un error enviado la verificación de email.'], 400);
            }
        }

        $log::get_log()->error('ENDPOINT: registrar_email ERROR: Ocurrió un error desconocido.'); */
        return $this->respuesta(400, [], ['Ocurrió un error desconocido.'], 400);
    }
}
