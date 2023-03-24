<?php

namespace App\DTO\Usuario;

use App\Repository\UsuarioRepository;

class UsuarioDTO
{
    protected $nombre;
    protected $apellido;
    protected $email;
    protected $telefono;
    protected $google_id;
    protected $google_access_token;
    protected $password;

    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido): void
    {
        $this->apellido = $apellido;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setTelefono($telefono): void
    {
        $this->telefono = $telefono;
    }

    public function setGoogleId($google_id): void
    {
        $this->google_id = $google_id;
    }

    public function setGoogleAccessToken($google_access_token): void
    {
        $this->google_access_token = $google_access_token;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function getGoogleId(): ?string
    {
        return $this->google_id;
    }

    public function getGoogleAccessToken(): ?string
    {
        return $this->google_access_token;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
