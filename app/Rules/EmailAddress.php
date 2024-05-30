<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\User;

class EmailAddress implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the email contains an @ symbol
        if (!str_contains($value, '@')) {
            $fail('The :attribute must contain an "@" symbol.');
            return;
        }
    }
}
