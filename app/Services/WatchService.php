<?php

namespace App\Services;

use App\Contracts\StockRepositoryInterface;
use App\Contracts\WatchRepositoryInterface;
use App\Contracts\WatchServiceInterface;

class WatchService implements WatchServiceInterface
{
    /**
     * @var WatchRepositoryInterface
     */
    protected $watchRepository;

    /**
     * @var StockRepositoryInterface
     */
    protected $stockRepository;

    public function __construct(
        WatchRepositoryInterface $watchRepository,
        StockRepositoryInterface $stockRepository
    )
    {
        $this->watchRepository = $watchRepository;
        $this->stockRepository = $stockRepository;
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $itemId)
    {
        // TODO: Implement delete() method.
    }

    public function getAll()
    {
        return  $this->watchRepository->all();
    }

    public function findById(int $id)
    {
        return $this->watchRepository->findById($id);
    }

    public function resetStore(): array
    {
        $items = $this->watchRepository->seedData();

        foreach($items as $item) {
            $this->stockRepository->setAmount($item, 1);
        }

        return $items;
    }

}
