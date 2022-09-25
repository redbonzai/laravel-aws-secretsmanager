<?php

namespace Getsolaris\LaravelAwsSecretsManager\Casters;

use Spatie\DataTransferObject\Caster;

class ArrayToJsonCaster implements Caster
{
    /**
     * @throws \JsonException
     */
    public function cast(mixed $value): string
    {
        return is_array($value) ? json_encode($value, JSON_THROW_ON_ERROR) : $value;
    }
}
