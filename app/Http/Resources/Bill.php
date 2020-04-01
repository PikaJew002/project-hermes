<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Family as FamilyResource;
use App\Http\Resources\MonthlyBill as MonthlyBillResource;

class Bill extends JsonResource
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
            'family_id' => $this->family_id,
            'family' => new FamilyResource($this->whenLoaded('family')),
            'monthly_bills' => MonthlyBillResource::collection($this->whenLoaded('monthlyBills')),
            // pivot_* only loaded when resource is loaded from 'bills'
            // on user
            'pivot_amount' => $this->whenPivotLoaded('bill_user', function () {
                return $this->pivot->amount;
            }),
            'pivot_created_at' => $this->whenPivotLoaded('bill_user', function () {
                return $this->pivot->created_at;
            }),
            'pivot_updated_at' => $this->whenPivotLoaded('bill_user', function () {
                return $this->pivot->updated_at;
            }),
            'name' => $this->name,
            'start_on' => $this->start_on,
            'end_on' => $this->end_on,
            'amount' => $this->amount,
            'due_day' => $this->due_day,
            'freq_per_year' => $this->freq_per_year,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
