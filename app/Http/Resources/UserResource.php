<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Only include these when explicitly loaded to avoid unnecessary counts
            'todos_count' => $this->whenCounted('todos'),
            'categories_count' => $this->whenCounted('categories'),
            
            // Only include these when explicitly requested
            $this->mergeWhen($request->routeIs('api.user.profile'), [
                'email_verified_at' => $this->email_verified_at,
            ]),
        ];
    }
} 