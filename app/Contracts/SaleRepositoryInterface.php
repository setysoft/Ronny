<?php

namespace App\Contracts;

interface SaleRepositoryInterface
{
    public function add($item, int $userId);

    public function all();

    public function allByUser(int $userId);

}
