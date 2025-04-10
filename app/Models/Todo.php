<?php

namespace App\Models;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
