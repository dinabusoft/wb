<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MasterMaterialResource extends JsonResource
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
			"code" => $this->code,
			"name" => $this->name,
			"pack" => $this->pack,
			"content" => $this->content,
			"remark" => $this->remark,
			"status" => $this->status,
			"created_at" => $this->created_at?->format('Y-m-d H:i:s'),
			"updated_at" => $this->updated_at?->format('Y-m-d H:i:s'),
			"deleted_at" => $this->deleted_at?->format('Y-m-d H:i:s'),
			"created_by_name" => $this->created_actor?->name,
			"updated_by_name" => $this->updated_actor?->name,
			"deleted_by_name" => $this->deleted_actor?->name,
        ];
    }
}
