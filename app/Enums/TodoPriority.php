<?php

namespace App\Enums;

enum TodoPriority: string
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';
}
