<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumber implements Rule
{
    public function passes($attribute, $value)
    {
        // Define your custom phone number validation logic here
        // For example, you can use a regular expression to validate the format
        return preg_match('/^\d{11}$/', $value); // Example: 11 or more digits
    }

    public function message()
    {
        return 'The :attribute must be a valid phone number.';
    }
}
