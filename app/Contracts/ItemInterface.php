<?php

namespace App\Contracts;


interface ItemInterface
{
    public function add(array $data);

    public function findById(int $id);

    public function update(array $data);

    public function delete(int $itemId);

    public function all();

}
