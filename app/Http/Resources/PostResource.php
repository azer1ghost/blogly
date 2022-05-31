<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->shortDetail,
            'slug' => $this->slug,
            'author' => isset($this->user->name) ? $this->user->name : 'Admin' ,
            'publication_date' => $this->publication_date->format('M d, Y'),
        ];
    }
}
