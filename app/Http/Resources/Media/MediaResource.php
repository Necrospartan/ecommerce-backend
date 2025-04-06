<?php

namespace App\Http\Resources\Media;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class MediaResource extends JsonResource
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
            'name' => $this->name,
            'location' => $this->location,
            'type' => $this->type,
            'image' => $this->image ? URL::route('getImageMedia', ['id' => $this->id]) : null,
            'price_per_day' => $this->price_per_day,
            'created_at' => $this->created_at ? $this->created_at->toDateString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toDateString() : null,
            'deleted_at' => $this->deleted_at ? $this->deleted_at->toDateString() : null
        ];
    }
}
