<?php

namespace Getsolaris\LaravelAwsSecretsManager;

use Illuminate\Support\ServiceProvider;

class AwsSecretsManagerServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    private string $name = 'aws-secretsmanager';

    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__."/../config/{$this->name}.php", $this->name);

        $this->app->singleton(AwsSecretsManager::class, function () {
            return new AwsSecretsManager();
        });
    }

    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__."/../config/{$this->name}.php" => config_path($this->name.'.php'),
        ], 'config');
    }
}
