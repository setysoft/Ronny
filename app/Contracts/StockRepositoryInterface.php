<?php

namespace App\Contracts;

interface StockRepositoryInterface
{
    public function all();

    public function setAmount(object $itemId, int $amount);

    public function decrement(object $item, int $amount);

    public function getAmount(object $item): int;
}
