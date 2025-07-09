<?php

namespace App\Enums;

enum TodoRepeatFrequency: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case CUSTOM = 'custom';

    /**
     * Get the display name for the repeat frequency.
     */
    public function label(): string
    {
        return match($this) {
            self::DAILY => 'Daily',
            self::WEEKLY => 'Weekly',
            self::MONTHLY => 'Monthly',
            self::CUSTOM => 'Custom',
        };
    }

    /**
     * Get all available options as an array.
     */
    public static function options(): array
    {
        return [
            self::DAILY->value => self::DAILY->label(),
            self::WEEKLY->value => self::WEEKLY->label(),
            self::MONTHLY->value => self::MONTHLY->label(),
            self::CUSTOM->value => self::CUSTOM->label(),
        ];
    }
} 