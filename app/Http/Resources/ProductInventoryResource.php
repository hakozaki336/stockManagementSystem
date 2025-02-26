<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductInventoryResource extends JsonResource
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
            'serial_number' => $this->serial_number,
            'location' => $this->location,
            'expiration_date' => $this->expiration_date->format('Y-m-d'),
            'assign' => $this->order_id ? true : false,
        ];
    }
}
