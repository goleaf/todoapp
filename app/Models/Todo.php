<?php

namespace App\Models;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'parent_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'priority' => TodoPriority::class,
        'status' => TodoStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the todo.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the parent todo.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Todo::class, 'parent_id');
    }

    /**
     * Get the subtasks for the todo.
     */
    public function subtasks(): HasMany
    {
        return $this->hasMany(Todo::class, 'parent_id');
    }
}
