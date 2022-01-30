<?php

namespace App\Http\Controllers;

use App\Contracts\PurchaseServiceInterface;
use App\Exceptions\CartEmptyException;
use App\Exceptions\NotEnoughInStockException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PurchaseController extends Controller
{
    /**
     * @var PurchaseServiceInterface
     */
    protected $purchaseService;

    public function __construct(PurchaseServiceInterface $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function proceed(Request $request)
    {
        //FIXME:: implement authentication !
        $userId = $request->post('user_id');
        try {
            $message = $this->purchaseService->proceed($userId);
            return response()->json(['success' => true, 'message' => $message]);

        } catch (CartEmptyException | NotEnoughInStockException $exception) {
            Log::error($exception);
            return response()->json(['success' => false, 'error' => $exception->getMessage()], 401);

        } catch (\Exception $exception) {
            Log::error($exception);

        }

        return response()->json('Something Went Wrong', 500);

    }
}
