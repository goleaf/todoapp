<?php

namespace App\Enums;

enum TodoStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
}
