<?php

namespace App\Http\Controllers;

use App\Exceptions\OutOfStockException;
use App\Exceptions\StockLogicException;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        $orders = $this->orderService->getAll();

        return response()->json([
            'data' => OrderResource::collection($orders),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request): Response
    {
        try {
            $this->orderService->store($request->validated());
        } catch (OutOfStockException $e) {
            return response()->json(['message' => $e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY]);
        }

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order): OrderResource
    {
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order): Response
    {
        try {
            $this->orderService->delete($order);
        } catch (StockLogicException $e) {
            return response()->json(['message' => $e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY]);
        }

        return response()->noContent();
    }

    public function dispatch(Order $order): Response
    {
        $this->orderService->dispatch($order);

        return response()->noContent();
    }

    public function undispatch(Order $order): Response
    {
        $this->orderService->undispatch($order);

        return response()->noContent();
    }

    public function pagenate(int $perpage = 5): JsonResponse
    {
        $orders = $this->orderService->getPaginatedOrders($perpage);

        return response()->json([
            'data' => OrderResource::collection($orders),
            'links' => [
                'prev' => $orders->previousPageUrl(),
                'next' => $orders->nextPageUrl(),
                'current' => $orders->url($orders->currentPage()),
            ],
        ]);
    }
}
