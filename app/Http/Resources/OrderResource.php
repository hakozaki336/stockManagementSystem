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
            'product_id' => $this->product_id,
            'product_name' => $this->product?->name,
            'company_id' => $this->company_id,
            'company_name' => $this->company?->name,
            'price' => $this->product?->price,
            'order_count' => $this->order_count,
            'assign' => $this->assign,
            'order_date' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
