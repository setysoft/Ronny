<?php

namespace App\Contracts;

interface CartServiceInterface
{
    public function addToCart(int $userId, int $id);

    public function clearCart(int $userId): bool;

    public function getCart(int $userId );

}
