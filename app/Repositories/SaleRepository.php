<?php

namespace App\Repositories;

use App\Contracts\SaleRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class SaleRepository implements SaleRepositoryInterface
{
    public const KEY_NAME = 'sales';

    public function add($item, int $userId)
    {
        $key = $this->getKeyName($userId);
        Redis::set($key, json_encode($item));
    }

    public function all()
    {
        $key = $this->getKeyName();
        return json_decode(Redis::get($key));
    }

    public function allByUser(int $userId)
    {
        $key = $this->getKeyName($userId);
        return json_decode(Redis::get($key));
    }

    private function getKeyName(int $userId = 1) : string
    {
        return implode(":", [self::KEY_NAME, $userId, 'items']);
    }
}
