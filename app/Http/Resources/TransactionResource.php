<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
			"date_in" => $this->date_in,
			"date_out" => $this->date_out,
			"time_in" => $this->time_in,
			"time_out" => $this->time_out,
			"weight_in" => $this->weight_in,
			"weight_out" => $this->weight_out,
			"ref_no" => $this->ref_no,
			"police_no" => $this->police_no,
			"driver_name" => $this->driver_name,
			"driver_phone" => $this->driver_phone,
			"materials_id" => $this->materials_id,
			"customers_id" => $this->customers_id,
			"remark" => $this->remark,
			"created_at" => $this->created_at,
			"updated_at" => $this->updated_at,
			"deleted_at" => $this->deleted_at,
			"created_by" => $this->created_by,
			"updated_by" => $this->updated_by,
			"deleted_by" => $this->deleted_by,

        ];
    }
}
