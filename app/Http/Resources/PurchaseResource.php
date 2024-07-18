<?php

namespace App\Http\Resources;

use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'user'       => new UserResource($this->user),
            'created_at' => $this->created_at->format("d/m/Y"),
            'games'      => GameResource::collection($this->games),
            'payments'   => PaymentResource::collection($this->payments)
        ];
    }
}
