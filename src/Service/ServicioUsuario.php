<?php

namespace App\Service;

use App\DTO\Usuario\ControlVersionDTO;
use App\DTO\Usuario\CambiarPasswordDTO;
use App\DTO\Usuario\GuardarTokenNotificacionesPushDTO;
use App\DTO\Usuario\PasswordProvisoriaDTO;
use App\DTO\Usuario\RegistrarEmailDTO;
use App\DTO\Usuario\ValidarEmailDTO;
use App\DTO\Usuario\RecuperarPasswordDTO;
use App\Model\Usuario;
use App\Repository\UsuarioRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ServicioUsuario
{
    protected $hasher_interface;
    protected $rep_usuario;
    protected $jwt_manager;

    public function __construct(UserPasswordHasherInterface $hasher_interface, UsuarioRepository $rep_usuario, JWTTokenManagerInterface $jwt_manager)
    {
        $this->hasher_interface = $hasher_interface;
        $this->rep_usuario = $rep_usuario;
        $this->jwt_manager = $jwt_manager;
    }

    public function encriptar_contraseña(UserInterface $usuario): string
    {
        $password = $this->get_hasher_interface()->hashPassword($usuario, $usuario->getPassword());
        return $password;
    }

    public function grabar_password(string $email, string $password, string $token): string
    {
        $usuario = $this->get_rep_usuario()->buscar_usuario_recuperar($email, $token);
        if ($usuario === null) {
            throw new \Exception('El token de modificación es inválido o el correo electrónico no existe.');
        }
        if ($usuario->get_estado() == 1) {
            throw new \Exception('El usuario no se encuentra activo.');
        }
        $usuario->set_password($password);
        $contraseña_encriptada = $this->encriptar_contraseña($usuario);
        $this->get_rep_usuario()->actualizar_password($email, $contraseña_encriptada);
        $token = $this->get_jwt_manager()->create($usuario);

        return $token;
    }

    /**
     * Realiza una validacion de email y hash, si encuentra email y hash enviados en base de datos devuelve true, caso 
     * contraria retorna falso.
     *
     * @param  ValidarEmailDTO $validar_email_dto
     * @return bool
     */
    public function validar_email(ValidarEmailDTO $validar_email_dto): bool
    {
        $usuario = $this->get_rep_usuario()->validar_email($validar_email_dto->to_array());
        if ($usuario !== null) {
            $this->get_rep_usuario()->actualizar_estado($validar_email_dto->getEmail());
            return true;
        }

        return false;
    }

    public function grabar_email(RegistrarEmailDTO $validar_email_dto)
    {
        $usuario = $this->get_rep_usuario()->buscar_usuario_email($validar_email_dto->getEmail());
        if ($usuario !== null) {
            $this->get_rep_usuario()->actualizar_hash($validar_email_dto->to_array());
            return;
        }
        $this->get_rep_usuario()->grabar_email($validar_email_dto->to_array());
    }

    public function cambiar_password(UserInterface $usuarios, CambiarPasswordDTO $cambiar_password_dto): bool
    {
        $usuario = $this->get_rep_usuario()->buscar_usuario_email($cambiar_password_dto->getUsername());
        if ($usuario === null) {
            throw new \Exception('El correo electrónico no existe.');
        }
        if ($usuario->get_estado() == 1) {
            throw new \Exception('El usuario no se encuentra activo.');
        }
        $oldPassOk = $this->get_hasher_interface()->isPasswordValid($usuario, $cambiar_password_dto->getPasswordOld());

        //$oldPassOk = $this->get_rep_usuario()->comprobar_password_old($cambiar_password_dto->to_array()); 

        if ($oldPassOk) {
            $usuario->set_password($cambiar_password_dto->getPassword());
            $contraseña_encriptada = $this->encriptar_contraseña($usuario);
            $usuario->set_password($cambiar_password_dto->getPassword());
            $this->get_rep_usuario()->actualizar_password($usuario->get_email(), $contraseña_encriptada);
        }
        return $oldPassOk;
    }

    public function recuperar_password(RecuperarPasswordDTO $recuperar_password_dto)
    {
        $this->get_rep_usuario()->recuperar_password($recuperar_password_dto->to_array());
    }

    protected function get_hasher_interface(): UserPasswordHasherInterface
    {
        return $this->hasher_interface;
    }

    public function encriptar_password_provisoria(PasswordProvisoriaDTO $dto_usuario)
    {
        $user = new Usuario();
        $user->set_password($dto_usuario->getPassword());
        return $this->encriptar_contraseña($user);
    }

    protected function get_rep_usuario(): UsuarioRepository
    {
        return $this->rep_usuario;
    }

    protected function get_jwt_manager(): JWTTokenManagerInterface
    {
        return $this->jwt_manager;
    }

    public function control_version(ControlVersionDTO $version): array
    {
        $version_actual = $_ENV['VERSION_APP'] > $version->getVersion();
        $link_play_store = $_ENV['LINK_PLAY_STORE'];
        $link_apple_store = $_ENV['LINK_APPLE_STORE'];

        $respuesta = [
            'actualizar'        => $version_actual,
            'link_play_store'   => $link_play_store,
            'link_apple_store'   => $link_apple_store
        ];

        return $respuesta;
    }

    public function guardar_token_notificaciones_push(GuardarTokenNotificacionesPushDTO $dto_guardar_notificaciones_push)
    {
        $token = $this->get_rep_usuario()->guardar_token_notificaciones_push($dto_guardar_notificaciones_push);

        return $token;
    }
}
