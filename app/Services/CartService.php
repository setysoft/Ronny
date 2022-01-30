<?php

namespace App\Services;

use App\Contracts\CartRepositoryInterface;
use App\Contracts\CartServiceInterface;
use App\Contracts\StockRepositoryInterface;
use App\Contracts\WatchRepositoryInterface;
use App\Exceptions\NotEnoughInStockException;
use Illuminate\Support\Facades\Log;

class CartService implements CartServiceInterface
{
    /**
     * @var CartRepositoryInterface
     */
    protected $cartRepository;

    /**
     * @var WatchRepositoryInterface
     */
    protected $watchRepository;

    /**
     * @var StockRepositoryInterface
     */
    protected $stockRepository;

    public const USER_ID = 1;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        WatchRepositoryInterface $watchRepository,
        StockRepositoryInterface $stockRepository
    )
    {
        $this->cartRepository = $cartRepository;
        $this->watchRepository = $watchRepository;
        $this->stockRepository = $stockRepository;
    }

    public function addToCart(int $id, $userId = null)
    {
        $item = $this->watchRepository
            ->findById($id);

        $amount = $this->stockRepository->getAmount($item);
        if(!$amount) {
            throw new NotEnoughInStockException;
        }
        $userId = $userId ?? self::USER_ID;
        $this->cartRepository->add($item, $userId);
    }

    public function getCart($userId = null)
    {
        $userId = $userId ?? self::USER_ID;
        return $this->cartRepository->all($userId);
    }

    public function clearCart(int $userId = null): bool
    {
        $userId = $userId ?? self::USER_ID;
        try{
            return $this->cartRepository->clear($userId);
        } catch (\Exception $exception) {
            Log::error($exception);
        }

        return false;
    }
}
