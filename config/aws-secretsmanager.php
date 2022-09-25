<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Using Cache Driver
    |--------------------------------------------------------------------------
    */
    'cache_driver' => env('CACHE_DRIVER'),

    /*
    |--------------------------------------------------------------------------
    | Cache Time To Live
    |--------------------------------------------------------------------------
    */
    'cache_ttl' => env('CACHE_TTL', 3600),

    /*
    |--------------------------------------------------------------------------
    | Cache Prefix
    |--------------------------------------------------------------------------
    */
    'prefix' => env('SECRETS_MANAGER_CACHE_PREFIX', config('cache.prefix') . 'secretsmanager_'),

    /*
    |--------------------------------------------------------------------------
    | AWS Credential Region
    |--------------------------------------------------------------------------
    */
    'region' => env('AWS_DEFAULT_REGION', 'us-west-2'),

    /*
    |--------------------------------------------------------------------------
    | AWS Secrets Manager API Version
    |--------------------------------------------------------------------------
    |
    | Supported API Versions: 2017-10-17
    | https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.SecretsManager.SecretsManagerClient.html
    |
    */
    'version' => '2017-10-17',

    /*
    |--------------------------------------------------------------------------
    | AWS Credentials
    |--------------------------------------------------------------------------
    |
    | Required permissions: secretsmanager:GetSecretValue.
    | If the secret is encrypted using a customer-managed key instead of the AWS managed key aws/secretsmanager
    |
    */
    'credentials' => [
        'key' => env('AWS_ACCESS_KEY_ID', ''),
        'secret' => env('AWS_SECRET_ACCESS_KEY', ''),
    ],
];
