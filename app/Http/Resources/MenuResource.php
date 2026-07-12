<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'route' => $this->route,
            'icon' => $this->icon,
            'order' => $this->order,
            'parent_uuid' => $this->parent_uuid,
            'permission' => $this->permission,
            'is_active' => $this->is_active,

            'children' => MenuResource::collection(
                $this->whenLoaded('children')
            ),
        ];
    }
}
