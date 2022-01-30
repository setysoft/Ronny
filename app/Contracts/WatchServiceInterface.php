<?php

namespace App\Contracts;

interface WatchServiceInterface
{
    public function create(array $data);

    public function update(array $data);

    public function delete(int $itemId);

    public function getAll();

}
