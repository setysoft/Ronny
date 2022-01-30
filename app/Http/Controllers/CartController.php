<?php

namespace App\Http\Controllers;

use App\Contracts\CartServiceInterface;
use App\Contracts\WatchServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * @var WatchServiceInterface
     */
    protected $watchService;

    /**
     * @var CartServiceInterface
     */
    protected $cartService;

    public function __construct(
        WatchServiceInterface $watchService,
        CartServiceInterface $cartService
    )
    {
        $this->watchService = $watchService;
        $this->cartService = $cartService;
    }

    public function addToCart(Request $request)
    {
        $id = $request->post('id');

        //FIXME:: implement authentication !
        $user_id = $request->post('user_id');
        try{
            $this->cartService->addToCart($id, $user_id);
        } catch (\Exception $exception)
        {
            Log::error($exception);
            return response()->json($exception->getMessage(), 401);
        }


        return response()->json($this->cartService->getCart());
    }

    public function getCart(Request $request, int $userId = null)
    {
        //FIXME:: implement authentication !
        return response()->json($this->cartService->getCart($userId));
    }

    public function clearCart()
    {
        $deleted = $this->cartService->clearCart();
        if($deleted) {
            return response()->json(['success' => true, 'error' => null]);
        }

        return response()->json([ 'success' => false, 'error' => 'Cart Clear Error'], 500);
    }
}
