<?php

namespace App\Http\Controllers;

use App\Exceptions\StockNotAvailableException;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $paginatedOrders = $this->orderService->getPaginatedOrders(5);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(
            [
                'data' => OrderResource::collection($paginatedOrders),
                'links' => [
                    'prev' => $paginatedOrders->previousPageUrl(),
                    'next' => $paginatedOrders->nextPageUrl(),
                    'current' => $paginatedOrders->url($paginatedOrders->currentPage()),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request): JsonResponse
    {
        try {
            $this->orderService->store($request->validated());
        } catch (StockNotAvailableException) {
            return response()->json(['message' => '商品の在庫が足りません'], 400);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json(null, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): JsonResponse
    {
        return response()->json($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order): JsonResponse
    {
        // TODO: 後のissueで正式な対応を行う

        // リクエストのデータを取得
        $data = $request->validated();
        // データを更新
        $order->update($data);
        // 更新したデータを返す
        return response()->json($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): JsonResponse
    {
        try {
            $this->orderService->delete($order);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '指定されたIDのデータが存在しません'], 404);
        } catch (Exception) {
            return response()->json(['message' => 'サーバー側でエラーが発生しました'], 500);
        }

        return response()->json([], 204);
    }
}
