<?php

namespace App\DTO\Products;


class OneProductDTO
{
    protected $code;

    public function to_array(): array
    {
        $resultado = [];
        $resultado['code'] = $this->getCode();
        return $resultado;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }
}
