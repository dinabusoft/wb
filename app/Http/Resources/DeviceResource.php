<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
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
			"port" => $this->port,
			"baudrate" => $this->baudrate,
			"databits" => $this->databits,
			"stopbits" => $this->stopbits,
			"parity" => $this->parity,
			"inputlen" => $this->inputlen,
			"threshold" => $this->threshold,
			"delimiter" => $this->delimiter,
			"index" => $this->index,
			"status" => $this->status,
			"remark" => $this->remark,
			"log" => $this->log,
			"created_at" => $this->created_at?->format('Y-m-d H:i:s'),
			"updated_at" => $this->updated_at?->format('Y-m-d H:i:s'),
			"deleted_at" => $this->deleted_at?->format('Y-m-d H:i:s'),
			"created_by_name" => $this->created_actor?->name,
			"updated_by_name" => $this->updated_actor?->name,
			"deleted_by_name" => $this->deleted_actor?->name,
			"user_id" => $this->user_id,
			"user_name" => $this->user_id?->name,

        ];
    }
}
