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

  /*   public function encriptar_contraseña(UserInterface $usuario): string
    {
        $password = $this->get_hasher_interface()->hashPassword($usuario, $usuario->getPassword());
        return $password;
    } */




}