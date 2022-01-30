<?php

namespace App\Repositories;

use App\Contracts\WatchRepositoryInterface;

use Illuminate\Support\Facades\Redis;

class WatchRepository implements WatchRepositoryInterface
{

    public const KEY_NAME = 'watches';

    public function add(array $data)
    {
        // TODO: Implement addItem() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $itemId)
    {
        // TODO: Implement delete() method.
    }

    public function all(): array
    {
        return array_map('json_decode', Redis::smembers(self::KEY_NAME));
    }

    public function findById(int $id)
    {
        $dataset = collect($this->all());

        return $dataset->where('watch_id', $id)->first();
    }

    public function seedData()
    {
        Redis::flushall();

        $this->addToList([
            'watch_id' => 123,
            'branch' => 'Rolex',
            'series' => 'Submariner',
            'model' => 'Model Name',
            'case_size' => 4,
            'bracelet_material' => 'metal',
            'dial_color' => ['red','yellow'],
            'status' => 1,
        ]);

        $this->addToList([
            'watch_id' => 124,
            'branch' => 'Omega',
            'series' => 'Omega APOLLO 11',
            'model' => 'SPEEDMASTER MISSIONS',
            'case_size' => 5,
            'bracelet_material' => 'titan',
            'dial_color' => ['blue','yellow'],
            'status' => 1,
        ]);

        $this->addToList([
            'watch_id' => 125,
            'branch' => 'Breitling',
            'series' => 'HERITAGE 46',
            'model' => 'SUPEROCEAN',
            'case_size' => 2,
            'bracelet_material' => 'plastic',
            'dial_color' => ['red','black'],
            'status' => 1,
        ]);

        return $this->all();
    }

    private function addToList(array $data)
    {
        Redis::sadd(self::KEY_NAME, json_encode($data));
    }
}
