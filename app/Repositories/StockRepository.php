<?php

namespace App\Repositories;

use App\Contracts\StockRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class StockRepository implements StockRepositoryInterface
{

    public const KEY_NAME = 'stock';

    public function all(): array
    {
        return array_map('json_decode', Redis::zrevrange(self::KEY_NAME, 0, -1));
    }

    public function getStock($item )
    {
        return Redis::zrank(self::KEY_NAME, json_encode($item));
    }

    public function findById(int $id)
    {
        $dataset = collect($this->all());

        return $dataset->where('watch_id', $id)->first();
    }

    public function addToStock(array $data, int $amount = 1)
    {
        Redis::incr(self::KEY_NAME, $amount, json_encode($data));
    }

    public function setAmount(object $item, int $amount)
    {
        $key = $this->getKeyName($item->watch_id);
        Redis::incr($key, $amount);
    }

    public function decrement(object $item, int $amount = 1)
    {
        $key = $this->getKeyName($item->watch_id);
        Redis::decr($key, $amount);
    }

    public function getAmount(object $item): int
    {
        $key = $this->getKeyName($item->watch_id);
        return Redis::get($key) ?? 0;
    }

    private function getKeyName(int $itemId) : string
    {
        return implode(":", [self::KEY_NAME, $itemId, 'amount']);
    }

}
