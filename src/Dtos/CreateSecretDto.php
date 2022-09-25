<?php

namespace Getsolaris\LaravelAwsSecretsManager\Dtos;

use Getsolaris\LaravelAwsSecretsManager\Casters\ArrayToJsonCaster;
use Getsolaris\LaravelAwsSecretsManager\Validators\JsonValidator;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-secretsmanager-2017-10-17.html#createsecret
 */
#[Strict]
class CreateSecretDto extends DataTransferObject
{
    /**
     * @var array|null (Optional) Specifies a list of Regions where you want to replicate the secret. You can't replicate a secret to the same Region where it's created. If you omit this parameter, then Secrets Manager automatically replicates the secret to all Regions that are enabled for replication.
     */
    public ?array $AddReplicaRegions;

    /**
     * @var string|null (Optional) Specifies a unique identifier for the new version of the secret.
     */
    public ?string $ClientRequestToken;

    /**
     * @var string|null (Optional) Specifies a user-provided description of the secret.
     */
    public ?string $Description;

    /**
     * @var bool|null (Optional) Specifies that if you replicate the secret to multiple Regions and the secret already exists in one of those Regions, you want to overwrite that secret with the new version that you're creating.
     */
    public ?bool $ForceOverwriteReplicaSecret;

    /**
     * @var string|null (Optional) Specifies the ARN or alias of the AWS KMS customer master key (CMK) to be used to encrypt the protected text in new versions of this secret.
     */
    public ?string $KmsKeyId;

    /**
     * @var string (Required) Specifies the friendly name of the new secret.
     */
    public string $Name;

    /**
     * @var string|null (Optional) Specifies binary data that you want to encrypt and store in the new version of the secret. To use this parameter in the command-line tools, we recommend that you store your binary data in a file and then use the appropriate technique for your tool to pass the contents of the file as a parameter. Either SecretString or SecretBinary must have a value, but not both. They cannot both be empty.
     */
    public ?string $SecretBinary;

    /**
     * @var string|array $SecretString (Required) Specifies text data that you want to encrypt and store in this new version of the secret. Either SecretString or SecretBinary must have a value, but not both. They cannot both be empty.
     */
    #[CastWith(ArrayToJsonCaster::class)]
    #[JsonValidator]
    public string|array $SecretString;

    /**
     * @var array|null (Optional) Specifies a list of user-defined tags that are attached to the secret. Each tag is a "Key" and "Value" pair of strings. This operation only appends tags to the existing list of tags. To remove tags, you must use UntagResource.
     */
    public ?array $Tags;
}
