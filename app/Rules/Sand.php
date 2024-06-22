<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Sand implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // SAND --- Space Alpha Numeric Dash
        if (preg_match('/[^а-яА-Яa-zA-Z0-9 -]/u', $value)) {
            $fail(__('validation.sand'));
        }
    }
}
