<?php

namespace App\Http\Controllers;

use App\Contracts\StockServiceInterface;
use App\Contracts\WatchServiceInterface;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * @var WatchServiceInterface
     */
    protected $watchService;

    /**
     * @var StockServiceInterface
     */
    protected $stockService;

    public function __construct(
        WatchServiceInterface $watchService,
        StockServiceInterface $stockService
    )
    {
        $this->watchService = $watchService;
        $this->stockService = $stockService;
    }

    public function getAmount(Request $request, int $id = null)
    {
        $item = $this->watchService->findById($id);
        $amount = $this->stockService->getAmount($item);
        return  response()->json(compact('item', 'amount'));
    }

    public function setAmount(Request $request, int $id = null)
    {
        $item = $this->watchService->findById($id);
        return $this->stockService->setAmount($item);
    }
}
