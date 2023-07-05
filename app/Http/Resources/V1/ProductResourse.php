<?php

namespace App\Http\Resources\V1;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
* @mixin Product
*/
class ProductResourse extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [
            'name_product' => $this->product,
            'price' => $this->price,
            'description' => $this->description,
            'image' => $this->image,
            'state' => $this->state,
        ];
    }
}
