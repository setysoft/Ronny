<?php

namespace App\Repositories;

use App\Contracts\CartRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class CartRepository implements CartRepositoryInterface
{
    public const KEY_NAME = 'cart';

    public function add($item, $user)
    {
        $key = $this->getKeyName($user);
        Redis::set($key, json_encode($item));
    }

    public function all(int $userId)
    {
        $key = $this->getKeyName($userId);
        return json_decode(Redis::get($key));
    }

    public function clear(int $userId): bool
    {
        $key = $this->getKeyName($userId);
        return Redis::del($key) === 1;
    }
    private function getKeyName(int $userId) : string
    {
        return implode(":", [self::KEY_NAME, $userId, 'items']);
    }

}
