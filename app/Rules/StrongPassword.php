<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Password should be at least 8 characters
        if (strlen($value) < 8) {
            $fail('The password must be at least 8 characters.');
            return;
        }

        // Password should contain at least one uppercase letter
        if (!preg_match('/[A-Z]/', $value)) {
            $fail('The password must contain at least one uppercase letter.');
            return;
        }

        // Password should contain at least one lowercase letter
        if (!preg_match('/[a-z]/', $value)) {
            $fail('The password must contain at least one lowercase letter.');
            return;
        }

        // Password should contain at least one number
        if (!preg_match('/[0-9]/', $value)) {
            $fail('The password must contain at least one number.');
            return;
        }

        // Password should contain at least one special character
        if (!preg_match('/[^A-Za-z0-9]/', $value)) {
            $fail('The password must contain at least one special character.');
            return;
        }
    }
} 