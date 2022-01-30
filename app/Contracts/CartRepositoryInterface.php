<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface CartRepositoryInterface
{
    public function add(array $item, $user);

    public function all(int $userId);

    public function clear(int $userId): bool;
}
