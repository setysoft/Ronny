<?php

namespace App\Services;

use App\Contracts\StockRepositoryInterface;
use App\Contracts\StockServiceInterface;
use App\Contracts\WatchRepositoryInterface;

class StockService implements StockServiceInterface
{
    /**
     * @var StockRepositoryInterface
     */
    protected $stockRepository;

    /**
     * @var WatchRepositoryInterface
     */
    protected $watchRepository;

    public function __construct(
        StockRepositoryInterface $stockRepository,
        WatchRepositoryInterface $watchRepository
    )
    {
        $this->stockRepository = $stockRepository;
        $this->watchRepository = $watchRepository;
    }

    public function add(array $data)
    {
        // TODO: Implement add() method.
    }

    public function remove(int $itemId)
    {
        // TODO: Implement remove() method.
    }

    public function all()
    {
        // TODO: Implement all() method.
    }


    public function getAll(int $id)
    {
        // TODO: Implement getAll() method.
    }

    public function getAmount(object $item)
    {
        return $this->stockRepository->getAmount($item);
    }

    public function setAmount(object $item, int $amount = 1)
    {
        return $this->stockRepository->setAmount($item, $amount);
    }
}
