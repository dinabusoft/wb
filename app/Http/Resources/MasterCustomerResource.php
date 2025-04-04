<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterCustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
			"id" => $this->id,
			"name" => $this->name,
			"street" => $this->street,
			"district" => $this->district,
			"regency" => $this->regency,
			"province" => $this->province,
			"postalcode" => $this->postalcode,
			"telephone" => $this->telephone,
			"phone" => $this->phone,
			"status" => $this->status,
			"remark" => $this->remark,
			"created_at" => $this->created_at?->format('Y-m-d H:i:s'),
			"updated_at" => $this->updated_at?->format('Y-m-d H:i:s'),
			"deleted_at" => $this->deleted_at?->format('Y-m-d H:i:s'),
			"created_by_name" => $this->created_actor?->name,
			"updated_by_name" => $this->updated_actor?->name,
			"deleted_by_name" => $this->deleted_actor?->name,

        ];
    }
}
