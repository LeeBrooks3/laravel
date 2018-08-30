<?php

namespace LeeBrooks3\Laravel\Providers;

use Illuminate\Auth\AuthManager;
use Illuminate\Auth\DatabaseUserProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LeeBrooks3\Models\ModelInterface;
use LeeBrooks3\Repositories\ModelRepositoryInterface;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Registers the database repository user provider.
     *
     * @return void
     */
    public function register() : void
    {
        /** @var AuthManager $auth */
        $auth = $this->app->make(AuthManager::class);

        $auth->provider('database_repository', function (Application $app, array $config) {
            /**
             * @var ModelInterface $model
             * @var ModelRepositoryInterface $repository
             * @var Hasher $hasher
             */
            $model = $app->make($config['model']);
            $repository = $app->make($config['repository']);
            $hasher = $app->make(Hasher::class);

            return new DatabaseUserProvider($model, $repository, $hasher);
        });
    }
}
