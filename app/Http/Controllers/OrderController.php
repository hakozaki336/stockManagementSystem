<?php

namespace App\Http\Controllers;

use App\Exceptions\DomainValidationException;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
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
    public function index(IndexAction $indexAction, Order $order): AnonymousResourceCollection
    {
        $orders = $indexAction($order);

        return OrderResource::collection($orders);
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

    public function paginate(PaginateAction $paginateAction, Order $order, int $perpage = 5): OrderCollection
    {
        $orders = $paginateAction($order, $perpage);

        return new OrderCollection($orders);
    }
}
