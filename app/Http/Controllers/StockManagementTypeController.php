<?php

namespace App\Http\Controllers;

use App\Enums\StockManagementType;
use App\Http\Resources\ProductAreaResource;
use App\Http\Resources\StockManagementTypeResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StockManagementTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $types = StockManagementType::cases();

        return StockManagementTypeResource::collection($types);
    }
}
