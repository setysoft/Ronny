<?php

namespace App\Services;

use App\Contracts\CartServiceInterface;
use App\Contracts\PurchaseServiceInterface;
use App\Contracts\StockRepositoryInterface;
use App\Events\ItemWasSold;
use App\Exceptions\CartEmptyException;
use App\Exceptions\NotEnoughInStockException;
use Exception;

class PurchaseService implements PurchaseServiceInterface
{
    public const User_ID = 1;

    /**
     * @var StockRepositoryInterface
     */
    protected $stockRepository;

    /**
     * @var CartServiceInterface
     */
    protected $cartService;

    public function __construct(
        StockRepositoryInterface $stockRepository,
        CartServiceInterface $cartService
    ) {
        $this->stockRepository = $stockRepository;
        $this->cartService = $cartService;
    }

    /**
     * @throws NotEnoughInStockException
     * @throws CartEmptyException
     */
    public function proceed($userId = null): string
    {
        $userId = $userId ?? self::User_ID;

        $cartItem = $this->cartService->getCart($userId);

        if(!$cartItem) {
            throw new CartEmptyException;
        }

        $inStock = $this->stockRepository->getAmount($cartItem);

        if(empty($cartItem) || !$inStock) {
            throw new NotEnoughInStockException;
        }

        $this->stockRepository->decrement($cartItem);

        event(new ItemWasSold($userId, $cartItem)) ;

        if($this->cartService->clearCart($userId)) {
            return 'Successfully Sold Message';
        }

        throw new Exception('Unknown error');
    }
}
