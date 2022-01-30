<?php

namespace App\Contracts;

interface StockServiceInterface
{
    public function getAll(int $id);

    public function getAmount(object $item);


}
