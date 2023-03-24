<?php

namespace App\Model;

use Symfony\Component\Security\Core\User\UserInterface;

class Usuario implements UserInterface
{
    protected $id;
    protected $nombre;
    protected $apellido;
    protected $email;
    protected $telefono;
    protected $google_id;
    protected $google_access_token;
    protected $password;
    protected $roles;
    protected $hash;
    protected $fecha_creacion;
    protected $fecha_modificacion;
    protected $fecha_inactivo;
    protected $estado;
    protected $fecha_recuperacion;
    protected $fecha_generacion_hash;

    public function __construct()
    {
        $this->roles = json_encode('["ROLE_USER"]');
        $this->hash = null;
        $this->fecha_creacion = date('Ymd H:i:s');
        $this->fecha_modificacion = null;
        $this->fecha_inactivo = null;
    }

    public function getRoles(): array
    {
        return ["ROLE_USER"];
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSalt(): string
    {
        return '';
    }

    public function eraseCredentials(): string
    {
        return '';
    }

    public function getUserIdentifier(): ?string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function get_id(): int
    {
        return (int) $this->id;
    }

    public function get_nombre(): string
    {
        return $this->nombre;
    }

    public function get_apellido(): string
    {
        return $this->apellido;
    }

    public function get_email(): string
    {
        return $this->email;
    }

    public function set_password(string $password)
    {
        $this->password = $password;
    }

    public function set_nombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function set_apellido(string $apellido): void
    {
        $this->apellido = $apellido;
    }

    public function set_email(string $email): void
    {
        $this->email = $email;
    }

    public function set_telefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function set_google_id(?string $google_id): void
    {
        $this->google_id = $google_id;
    }

    public function set_google_access_token(?string $google_access_token): void
    {
        $this->google_access_token = $google_access_token;
    }

    public function get_telefono(): string
    {
        return $this->telefono;
    }

    public function get_roles(): string
    {
        return $this->roles;
    }

    public function get_google_access_token(): ?string
    {
        return $this->google_access_token;
    }


    public function get_google_id(): ?string
    {
        return $this->google_id;
    }

    public function get_hash(): ?string
    {
        return $this->hash;
    }

    public function get_fecha_creacion(): string
    {
        return $this->fecha_creacion;
    }

    public function get_fecha_modificacion(): ?string
    {
        return $this->fecha_modificacion;
    }

    public function get_fecha_inactivo(): ?string
    {
        return $this->fecha_inactivo;
    }

    public function get_estado(): ?string
    {
        return $this->estado;
    }

    public function get_fecha_recuperacion(): ?string
    {
        return $this->fecha_recuperacion;
    }

    public function get_password(): ?string
    {
        return $this->password;
    }

    public function get_fecha_generacion_hash(): string
    {
        return $this->fecha_generacion_hash;
    }

    public function to_array(): array
    {
        $respuesta = [];

        $respuesta['id'] = $this->get_id();
        $respuesta['nombre'] = $this->get_nombre();
        $respuesta['apellido'] = $this->get_apellido();
        $respuesta['email'] = $this->get_email();
        $respuesta['telefono'] = $this->get_telefono();
        $respuesta['google_id'] = $this->get_google_id();
        $respuesta['google_access_token'] = $this->get_google_access_token();
        $respuesta['password'] = $this->get_password();
        $respuesta['roles'] = $this->get_roles();
        $respuesta['hash'] = $this->get_hash();
        $respuesta['fecha_creacion'] = $this->get_fecha_creacion();
        $respuesta['fecha_modificacion'] = $this->get_fecha_modificacion();
        $respuesta['fecha_inactivo'] = $this->get_fecha_inactivo();
        $respuesta['estado'] = $this->get_estado();
        $respuesta['fecha_recuperacion'] = $this->get_fecha_recuperacion();
        $respuesta['fecha_generacion_hash'] = $this->get_fecha_generacion_hash();

        return $respuesta;
    }
}
