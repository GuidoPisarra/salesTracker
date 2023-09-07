<?php

namespace App\Service;

use App\DTO\ChangesProduct\ChangeProductDTO;
use App\Repository\ChangeProductRepository;

class ChangeProductService
{
    protected $rep_expense;

    public function __construct(ChangeProductRepository $rep_expense)
    {
        $this->rep_expense = $rep_expense;
    }

    public function add_change(ChangeProductDTO $dto)
    {
        return $this->rep_expense->add_change($dto);
    }
}
