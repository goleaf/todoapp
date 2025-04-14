<?php

namespace App\Enums;

use Illuminate\Support\Facades\Lang;

enum TodoPriority: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function label(): string
    {
        return Lang::get('todo.priority_' . $this->value);
    }
}
