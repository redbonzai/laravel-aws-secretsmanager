# A Laravel package to retrieve key management from AWS Secrets Manager

[![Latest Version on Packagist](https://img.shields.io/packagist/v/getsolaris/laravel-aws-secretsmanager.svg?style=flat-square)](https://packagist.org/packages/getsolaris/laravel-aws-secretsmanager)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/getsolaris/laravel-aws-secretsmanager/run-tests?label=tests)](https://github.com/getsolaris/laravel-aws-secretsmanager/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/getsolaris/laravel-aws-secretsmanager/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/getsolaris/laravel-aws-secretsmanager/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/getsolaris/laravel-aws-secretsmanager.svg?style=flat-square)](https://packagist.org/packages/getsolaris/laravel-aws-secretsmanager)


Communication via `AWS Secrets Manager` may incur unnecessary charges.

So we developed a package that simply caches.

## Installation

You can install the package via composer:

```bash
composer require getsolaris/laravel-aws-secretsmanager
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Getsolaris\LaravelAwsSecretsManager\AwsSecretsManagerServiceProvider" --tag="config"
```

## Usage

You can choose cache driver and cache ttl

default cache driver is `filesystem` (`storage/framework/cache/data`)

```bash
# .env
CACHE_DRIVER=redis
CACHE_TTL=86400

# aws configuration
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
```

Required permissions: `secretsmanager:GetSecretValue`

If the secret is encrypted using a customer-managed key instead of the AWS managed key `aws/secretsmanager`

## Example

### createSecret

```php
<?php

namespace App\Services;

use Getsolaris\LaravelAwsSecretsManager\AwsSecretsManager;

class FacebookApiService extends Service
{
    protected AwsSecretsManager $client;
    public function __construct()
    {
        $this->client = new AwsSecretsManager();
    }

    /**
     * @param string $secretId
     * @return array
     * @throws \Exception
     */
    public function createFacebookSecret(): \Aws\Result
    {
        $appId = env('FACEBOOK_APP_ID', 'test_app_id_123');
        $appSecret = env('FACEBOOK_APP_SECRET', 'test_app_secret_123');
        
        $createSecret = new CreateSecretDto(
            Name: 'prod/facebook/secret',
            SecretString: [
                'app_id' => $appId,
                'app_secret' => $appSecret,
            ],
        );
        
        $createSecret = new CreateSecretDto([       
            'Name' => 'prod/facebook/secret',
            'SecretString' => [
                'app_id' => $appId,
                'app_secret' => $appSecret,
            ],
        ]);
    
        return $this->client->createSecret($createSecret);
    }
}
```

### getSecret

```php
<?php

namespace App\Services;

use Getsolaris\LaravelAwsSecretsManager\AwsSecretsManager;

class FacebookApiService extends Service
{
    protected AwsSecretsManager $client;
    public function __construct()
    {
        $this->client = new AwsSecretsManager();
    }

    /**
     * @param string $secretId
     * @return array
     * @throws \Exception
     */
    public function getFacebookSecret(): \Aws\Result
    {
        return $this->client->getSecret('prod/facebook/secret');
    }
}
```

### getSecretValue

```php
<?php

namespace App\Services;

use Getsolaris\LaravelAwsSecretsManager\AwsSecretsManager;

class FacebookApiService extends Service
{
    protected AwsSecretsManager $client;
    public function __construct()
    {
        $this->client = new AwsSecretsManager();
    }

    /**
     * @param string $secretId
     * @return array
     * @throws \Exception
     */
    public function getFacebookSecretValue(): array
    {
        return $this->client->getSecretValue('prod/facebook/secret');
    }
}
```

## Resource
- [AWS SDK for PHP Version 3](https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/secretsmanager-examples-manage-secret.html)
- [Spatie Data Transfer Object](https://github.com/spatie/data-transfer-object)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
