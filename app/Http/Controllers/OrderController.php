<?php

namespace App\Http\Controllers;

use App\Exceptions\DomainValidationException;
use App\Exceptions\OutOfStockException;
use App\Exceptions\StockLogicException;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\UseCases\Order\DestroyAction;
use App\UseCases\Order\IndexAction;
use App\UseCases\Order\PaginateAction;
use App\UseCases\Order\StoreAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexAction $indexAction, Order $order): JsonResponse
    {
        $orders = $indexAction($order);

        return response()->json([
            'data' => OrderResource::collection($orders),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request, StoreAction $storeAction): Response | JsonResponse
    {
        try {
            $storeAction($request->validated());
        } catch (DomainValidationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
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
    public function destroy(Order $order, DestroyAction $destroyAction): Response
    {
        try {
            $destroyAction($order);
        } catch (DomainValidationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    public function dispatch(Order $order): Response
    {
        $order->dispatch();

        return response()->noContent();
    }

    public function undispatch(Order $order): Response
    {
        $order->undispatch();

        return response()->noContent();
    }

    public function paginate(PaginateAction $paginateAction, Order $order, int $perpage = 5): JsonResponse
    {
        $orders = $paginateAction($order, $perpage);

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
