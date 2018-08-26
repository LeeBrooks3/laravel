<?php

namespace LeeBrooks3\Laravel\Database;

use Illuminate\Database\Eloquent\Factory;

/**
 * @property \Illuminate\Contracts\Foundation\Application app
 */
trait ModelFactories
{
    /**
     * The defined model factories.
     *
     * @var ModelFactory[]
     */
    private $factories = [];

    /**
     * Defines a model factory.
     *
     * @param string $model
     * @param string $table
     * @param \Closure|null $closure
     */
    protected function defineFactory(string $model, string $table, \Closure $closure = null)
    {
        $this->factories[$model] = new ModelFactory($model, $table, $closure);
    }

    /**
     * Returns a model factory.
     *
     * @param string $model
     * @return ModelFactory
     */
    protected function factory(string $model)
    {
        $modelFactory = $this->factories[$model];

        $table = $modelFactory->getTable();

        /** @var Factory $factory */
        $factory = $this->app->make(Factory::class);
        $builder = $factory->of($table);

        $modelFactory->setBuilder($builder);

        return $modelFactory;
    }
}
