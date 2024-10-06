<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_name' => $this->product?->name,
            'company_name' => $this->company?->name,
            'order_count' => $this->order_count,
            'dispatched' => $this->dispatched,
            'order_date' => $this->created_at,
        ];
    }
}
