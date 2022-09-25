<?php

namespace Getsolaris\LaravelAwsSecretsManager\Dtos;

use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-secretsmanager-2017-10-17.html#rotatesecret
 */
#[Strict]
class RotateSecretDto extends DataTransferObject
{
    /**
     * @var string|null (Optional) Specifies a unique identifier for the new version of the secret.
     */
    public ?string $ClientRequestToken;

    /**
     * @var bool|null (Optional) Specifies that the secret is to be rotated without waiting for the
     */
    public ?bool $RotateImmediately;

    /**
     * @var string|null (Optional) Specifies the ARN of the Lambda function that can rotate the secret.
     */
    public ?string $RotationLambdaARN;

    /**
     * @var array|null (Optional) Specifies the ARN of the Lambda function that can rotate the secret.
     */
    public ?array $RotationRules;

    /**
     * @var string (Required) Specifies the secret that you want to rotate. You can specify either the Amazon Resource Name (ARN) or the friendly name of the secret.
     */
    public string $SecretId;

    /**
     * @var bool|null (Optional) Specifies that the secret is to be deleted from the rotation schedule.
     */
    public ?bool $ForceDeleteWithoutRecovery;
}
