<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Family as FamilyResource;
use App\Http\Resources\Bill as BillResource;

class User extends JsonResource
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
            'families' => FamilyResource::collection($this->whenLoaded('families')),
            'bills' => BillResource::collection($this->whenLoaded('bills')),
            // pivot_* only loaded when resource is loaded from 'users'
            // on bill
            'pivot_amount' => $this->whenPivotLoaded('bill_user', function () {
                return $this->pivot->amount;
            }),
            'pivot_created_at' => $this->whenPivotLoaded('bill_user', function () {
                return $this->pivot->created_at;
            }),
            'pivot_updated_at' => $this->whenPivotLoaded('bill_user', function () {
                return $this->pivot->updated_at;
            }),
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
