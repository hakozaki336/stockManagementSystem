<?php

namespace App\Http\Controllers;

use App\Enums\ProductArea;
use App\Http\Resources\ProductAreaResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $areas = ProductArea::cases();

        return ProductAreaResource::collection($areas);
    }
}
