<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Bill as BillResource;
use App\Http\Resources\Payment as PaymentResource;

class MonthlyBill extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'bill_id' => $this->bill_id,
            'bill' => new BillResource($this->whenLoaded('bill')),
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
