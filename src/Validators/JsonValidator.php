<?php

namespace Getsolaris\LaravelAwsSecretsManager\Validators;

use Attribute;
use Spatie\DataTransferObject\Attributes;
use Spatie\DataTransferObject\Validation\ValidationResult;
use Spatie\DataTransferObject\Validator;

#[Attribute]
class JsonValidator implements Validator
{
    /**
     * @param mixed $value
     * @return ValidationResult
     */
    public function validate(mixed $value): ValidationResult
    {
        try {
            json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            return ValidationResult::invalid("Value is not a valid JSON string");
        }

        return ValidationResult::valid();
    }
}
