<?php

namespace App\Models;

use App\Enums\TodoPriority;
use App\Enums\TodoStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

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
        'is_recurring',
        'repeat_frequency',
        'repeat_interval',
        'repeat_days',
        'repeat_until',
        'recurring_parent_id',
        'last_generated_at',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'priority' => TodoPriority::class,
        'status' => TodoStatus::class,
        'is_recurring' => 'boolean',
        'repeat_days' => 'array',
        'repeat_until' => 'date',
        'last_generated_at' => 'datetime',
    ];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = []; // Removed automatic eager loading to improve performance
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_completed', 'subtasks_count', 'completed_subtasks_count'];

    /**
     * Get the user that owns the todo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the todo.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Uncategorized',
            'color' => '#6B7280',
        ]);
    }

    /**
     * Get the parent todo.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Todo::class, 'parent_id');
    }

    /**
     * Get the recurring parent todo.
     */
    public function recurringParent(): BelongsTo
    {
        return $this->belongsTo(Todo::class, 'recurring_parent_id');
    }

    /**
     * Get the subtasks for the todo.
     */
    public function subtasks(): HasMany
    {
        return $this->hasMany(Todo::class, 'parent_id');
    }

    /**
     * Get the recurrence instances for this recurring todo.
     */
    public function recurrenceInstances(): HasMany
    {
        return $this->hasMany(Todo::class, 'recurring_parent_id');
    }
    
    /**
     * Scope a query to include only completed todos.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', TodoStatus::COMPLETED);
    }
    
    /**
     * Scope a query to include only non-completed todos.
     */
    public function scopeIncomplete(Builder $query): Builder
    {
        return $query->where('status', '!=', TodoStatus::COMPLETED);
    }
    
    /**
     * Scope a query to include only current user's todos.
     */
    public function scopeOwned(Builder $query): Builder
    {
        return $query->where('user_id', Auth::id());
    }
    
    /**
     * Scope a query to include only top-level todos (no parent).
     */
    public function scopeTopLevel(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }
    
    /**
     * Scope a query to include only overdue todos.
     */
    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('due_date', '<', now())
            ->where('status', '!=', TodoStatus::COMPLETED);
    }
    
    /**
     * Scope a query to include only today's todos.
     */
    public function scopeDueToday(Builder $query): Builder
    {
        return $query->whereDate('due_date', now());
    }

    /**
     * Get the is_completed attribute.
     */
    public function getIsCompletedAttribute(): bool
    {
        return $this->status === TodoStatus::COMPLETED;
    }
    
    /**
     * Get the subtasks_count attribute.
     */
    public function getSubtasksCountAttribute(): int
    {
        return $this->subtasks()->count();
    }
    
    /**
     * Get the completed_subtasks_count attribute.
     */
    public function getCompletedSubtasksCountAttribute(): int
    {
        return $this->subtasks()->completed()->count();
    }

    /**
     * Check if this todo is part of a recurring series.
     */
    public function isRecurringSeries(): bool
    {
        return $this->is_recurring || $this->recurring_parent_id !== null;
    }

    /**
     * Check if this todo is the template/parent of a recurring series.
     */
    public function isRecurringParent(): bool
    {
        return $this->is_recurring && $this->recurring_parent_id === null;
    }

    /**
     * Check if this todo is an instance generated from a recurring parent.
     */
    public function isRecurringInstance(): bool
    {
        return $this->recurring_parent_id !== null;
    }

    /**
     * Get the formatted repeat frequency.
     */
    public function getRepeatFrequencyText(): string
    {
        if (!$this->is_recurring) {
            return 'Not recurring';
        }

        switch ($this->repeat_frequency) {
            case 'daily':
                return $this->repeat_interval > 1 
                    ? "Every {$this->repeat_interval} days" 
                    : "Daily";
            case 'weekly':
                if ($this->repeat_interval > 1) {
                    return "Every {$this->repeat_interval} weeks" . $this->getRepeatDaysText();
                }
                return "Weekly" . $this->getRepeatDaysText();
            case 'monthly':
                return $this->repeat_interval > 1 
                    ? "Every {$this->repeat_interval} months" 
                    : "Monthly";
            case 'custom':
                return "Custom";
            default:
                return "Unknown";
        }
    }

    /**
     * Get formatted text for repeat days.
     */
    private function getRepeatDaysText(): string
    {
        if ($this->repeat_frequency !== 'weekly' || empty($this->repeat_days)) {
            return '';
        }

        $dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $days = array_map(function($day) use ($dayNames) {
            return $dayNames[$day - 1] ?? '';
        }, $this->repeat_days);

        return ' on ' . implode(', ', $days);
    }
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        // Apply default order
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }
}
