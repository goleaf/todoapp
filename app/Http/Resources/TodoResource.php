<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'status' => $this->status,
            'due_date' => $this->due_date,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Relationships
            'category' => new CategoryResource($this->whenLoaded('category')),
            'parent' => new TodoResource($this->whenLoaded('parent')),
            'subtasks' => TodoResource::collection($this->whenLoaded('subtasks')),
            'subtasks_count' => $this->whenCounted('subtasks'),
        ];
    }
} 