<?php

namespace Tests\Traits;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Assert;

trait HasValidationAssertions
{
    public function assertValidationPasses(string $requestClass, string $field, string $name, mixed $value): void
    {
        if (!$this->passesValidation($requestClass, $field, $value)) {
            throw new Exception("Failed asserting that field '$field' passes at value '$value' in subtest '$name'");
        }
    }


    public function assertValidationFails(string $requestClass, string $field, string $name, mixed $value): void
    {
        if ($this->passesValidation($requestClass, $field, $value)) {
            throw new Exception("Failed asserting that field '$field' fails at value '$value' in subtest '$name'");
        }
    }


    private function passesValidation(string $requestClass, string $field, mixed $value): bool
    {
        return Validator::make(
            [$field => $value],
            [$field => (new $requestClass())->rules()[$field]]
        )->passes();
    }
}
