<?php

namespace Getsolaris\LaravelAwsSecretsManager;

use Aws\Result;
use Aws\SecretsManager\SecretsManagerClient;
use Exception;
use Getsolaris\LaravelAwsSecretsManager\Dtos\CreateSecretDto;
use Getsolaris\LaravelAwsSecretsManager\Dtos\ListSecretsDto;
use Getsolaris\LaravelAwsSecretsManager\Dtos\PutSecretDto;
use Getsolaris\LaravelAwsSecretsManager\Dtos\RotateSecretDto;
use Illuminate\Support\Facades\Cache;
use JsonException;

class AwsSecretsManager
{
    /**
     * @var SecretsManagerClient $client
     */
    protected SecretsManagerClient $client;

    public function __construct()
    {
        config()->set('cache.prefix', config('aws-secretsmanager.prefix'));
        app('cache')->forgetDriver(config('cache.default'));
    }

    /**
     * @return $this
     */
    protected function connection(): self
    {
        $this->client = new SecretsManagerClient([
            'region' => config('aws-secretsmanager.region'),
            'version' => config('aws-secretsmanager.version'),
            'credentials' => [
                'key' => config('aws-secretsmanager.credentials.key'),
                'secret' => config('aws-secretsmanager.credentials.secret'),
            ],
        ]);

        return $this;
    }

    /**
     * @param CreateSecretDto $createSecretDto
     * @return Result
     */
    public function createSecret(CreateSecretDto $createSecretDto): Result
    {
        $result = $this->connection()->client->createSecret($createSecretDto->toArray());

        $this->putCache($result);

        return $result;
    }

    /**
     * @param string $secretId
     * @return Result
     */
    public function describeSecret(string $secretId): Result
    {
        return $this->connection()->client->describeSecret([
            'SecretId' => $secretId,
        ]);
    }

    /**
     * @param PutSecretDto $putSecretDto
     * @return Result
     */
    public function putSecretValue(PutSecretDto $putSecretDto): Result
    {
        $result = $this->connection()->client->putSecretValue($putSecretDto->toArray());

        $this->putCache($result);

        return $result;
    }

    /**
     * @param RotateSecretDto $rotateSecretDto
     * @return Result
     */
    public function rotateSecret(RotateSecretDto $rotateSecretDto): Result
    {
        return $this->connection()->client->rotateSecret($rotateSecretDto->toArray());
    }

    /**
     * @param string $secretId
     * @return Result
     */
    public function deleteSecret(string $secretId): Result
    {
        $result = $this->connection()->client->deleteSecret([
            'SecretId' => $secretId,
        ]);

        $this->forgetCache($secretId);

        return $result;
    }

    /**
     * @param ListSecretsDto $listSecretsDto
     * @return Result
     */
    public function listSecrets(ListSecretsDto $listSecretsDto): Result
    {
        $secrets = $this->connection()->client->listSecrets($listSecretsDto->toArray());
        foreach ($secrets['SecretList'] as $secret) {
            $this->putCache($secret);
        }

        return $secrets;
    }

    /**
     * @param string $secretId
     * @return Result
     */
    public function getSecret(string $secretId): Result
    {
        if (Cache::has($secretId)) {
            return $this->getSecretCache($secretId);
        }

        $result = $this->connection()->client->getSecretValue([
            'SecretId' => $secretId,
        ]);

        $this->putCache($result);

        return $result;
    }

    /**
     * @param string $secretId
     * @return array
     * @throws JsonException
     * @throws Exception
     */
    public function getSecretValue(string $secretId): array
    {
        return $this->getSecretToArray($this->getSecret($secretId));
    }

    /**
     * @param Result $result
     * @return array
     * @throws JsonException
     */
    protected function getSecretToArray(Result $result): array
    {
        return json_decode($result->get('SecretString'), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @param $secretId
     * @return mixed
     */
    protected function getSecretCache($secretId): mixed
    {
        return Cache::get($secretId);
    }

    /**
     * @param Result $result
     * @return void
     */
    protected function putCache(Result $result): void
    {
        Cache::put($result['Name'], $result, config('aws-secretsmanager.cache_ttl'));
    }

    /**
     * @param string $secretId
     * @return bool
     */
    public function forgetCache(string $secretId): bool
    {
        return Cache::forget($secretId);
    }
}
