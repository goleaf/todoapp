<?php

namespace App\Enums;

use Illuminate\Support\Facades\Lang;

enum TodoStatus: string
{
    case NotStarted = 'not_started';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case OnHold = 'on_hold';
    case Cancelled = 'cancelled';
    case Pending = 'pending';

    public function label(): string
    {
        return Lang::get('todo.status_' . $this->value);
    }
}
