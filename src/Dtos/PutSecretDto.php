<?php

namespace Getsolaris\LaravelAwsSecretsManager\Dtos;

use Getsolaris\LaravelAwsSecretsManager\Casters\ArrayToJsonCaster;
use Getsolaris\LaravelAwsSecretsManager\Validators\JsonValidator;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-secretsmanager-2017-10-17.html#putsecretvalue
 */
#[Strict]
class PutSecretDto extends DataTransferObject
{
    /**
     * @var string|null $ClientRequestToken (Optional) Specifies a unique identifier for the new version of the secret.
     */
    public ?string $ClientRequestToken;

    /**
     * @var string|\Psr\Http\Message\StreamInterface $SecretBinary (Optional) Specifies binary data that you want to encrypt and store in the new version of the secret. To use this parameter in the command-line tools, we recommend that you store your binary data in a file and then use the appropriate technique for your tool to pass the contents of the file as a parameter. Either SecretBinary or SecretString must have a value, but not both. They cannot both be empty.
     */
    public string|\Psr\Http\Message\StreamInterface $SecretBinary;

    /**
     * @var string $SecretId (Required) Specifies the secret that you want to create or modify.
     */
    public string $SecretId;

    /**
     * @var string|array|null $SecretString (Optional) Specifies text data that you want to encrypt and store in this new version of the secret. Either SecretBinary or SecretString must have a value, but not both. They cannot both be empty.
     */
    #[CastWith(ArrayToJsonCaster::class)]
    #[JsonValidator]
    public string|array|null $SecretString;

    /**
     * @var array|null $VersionStages (Optional) Specifies a list of staging labels that are attached to this version of the secret. These staging labels are used to track the versions through the rotation process by the Lambda rotation function.
     */
    public ?array $VersionStages;
}
