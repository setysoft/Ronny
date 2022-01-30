<?php

namespace App\Http\Controllers;

use App\Contracts\StockServiceInterface;
use App\Contracts\WatchServiceInterface;
use App\Http\Requests\CreateWatchRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WatchController extends Controller
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

    /**
     * Returns auth user's profile information.
     *
     * @return JsonResponse
     */
    public function list()
    {
        return response()->json($this->watchService->getAll());
    }

    public function addToStock(CreateWatchRequest $request)
    {
        return $this->watchService->create($request->validated());
    }

    public function show(Request $request, int $id)
    {
        return response()->json($this->watchService->findById($id));
    }

    public function reset()
    {
        return $this->watchService->resetStore();
    }



}
