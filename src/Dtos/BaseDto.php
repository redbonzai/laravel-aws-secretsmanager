<?php

namespace Getsolaris\LaravelAwsSecretsManager\Dtos;

use Spatie\DataTransferObject\DataTransferObject;

class BaseDto extends DataTransferObject
{
    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = parent::toArray();
        $collect = collect($result);

        return $collect->filter()->toArray();
    }
}
