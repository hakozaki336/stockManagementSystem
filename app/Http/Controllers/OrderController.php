<?php

namespace App\Http\Controllers;

use App\Exceptions\DomainValidationException;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\ApplicationServices\Order\OrderCreateService;
use App\Services\ApplicationServices\Order\OrderDestroyService;
use App\Services\ApplicationServices\Order\OrderListService;
use App\Services\ApplicationServices\Order\OrderPaginationService;
use App\UseCases\Order\DestroyAction;
use App\UseCases\Order\IndexAction;
use App\UseCases\Order\PaginateAction;
use App\UseCases\Order\StoreAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrderListService $orderListService): AnonymousResourceCollection
    {
        $orders = $orderListService();

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderStoreRequest $request, OrderCreateService $orderCreateService): Response | JsonResponse
    {
        try {
            $orderCreateService($request->validated());
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
    public function destroy(Order $order, OrderDestroyService $orderDestroyService): Response|JsonResponse
    {
        try {
            $orderDestroyService($order);
        } catch (DomainValidationException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->noContent();
    }

    public function assign(Order $order): Response
    {
        $order->assign()->save();

        return response()->noContent();
    }

    public function unassign(Order $order): Response
    {
        $order->unassign()->save();

        return response()->noContent();
    }

    public function paginate(OrderPaginationService $orderPaginationService, int $perpage = 5): OrderCollection
    {
        $orders = $orderPaginationService($perpage);

        return new OrderCollection($orders);
    }
}
