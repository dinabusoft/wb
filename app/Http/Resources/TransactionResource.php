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
			"ticket_id" => sprintf( 'WB%08d', $this->id ),
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
			"materials_name" => ($this->material?$this->material->name:''),
			"customers_name" => ($this->customer?$this->customer->name:''),
			"remark" => $this->remark,
			"created_at" => $this->created_at?->format('Y-m-d H:i:s'),
			"updated_at" => $this->updated_at?->format('Y-m-d H:i:s'),
			"deleted_at" => $this->deleted_at?->format('Y-m-d H:i:s'),
			"created_by_name" => $this->created_actor?->name,
			"updated_by_name" => $this->updated_actor?->name,
			"deleted_by_name" => $this->deleted_actor?->name,
			"status"=> ($this->date_out!=null && !empty($this->date_out)?"Check out":"Check in")
        ];
    }
}
