<?php

namespace LeeBrooks3\Laravel\Database;

use Illuminate\Database\Eloquent\FactoryBuilder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use LeeBrooks3\Models\ModelInterface;

/**
 * @mixin FactoryBuilder
 */
class ModelFactory
{
    /**
     * The model class name.
     *
     * @var string
     */
    private $model;

    /**
     * The table class name.
     *
     * @var string
     */
    private $table;

    /**
     * The closure to transform the table results (eloquent models) into models.
     *
     * @var \Closure
     */
    private $closure;

    /**
     * The factory builder instance for the table.
     *
     * @var FactoryBuilder
     */
    private $builder;

    /**
     * @param string $model
     * @param string $table
     * @param \Closure $closure
     */
    public function __construct(string $model, string $table, \Closure $closure = null)
    {
        $this->model = $model;
        $this->table = $table;
        $this->closure = $closure;
    }

    /**
     * Calls the method of the table factory builder if the method doesn't exist on the model factory builder.
     *
     * @param $name
     * @param $arguments
     */
    public function __call(string $name, array $arguments)
    {
        $builder = $this->getBuilder();

        $builder->__call($name, $arguments);
    }

    /**
     * Returns the table class name.
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Returns the factory builder instance.
     *
     * @return FactoryBuilder
     */
    public function getBuilder(): FactoryBuilder
    {
        return $this->builder;
    }

    /**
     * Sets the factory builder instance.
     *
     * @param FactoryBuilder $builder
     */
    public function setBuilder(FactoryBuilder $builder): void
    {
        $this->builder = $builder;
    }

    /**
     * Creates a collection of models and persist them to the database.
     *
     * @param array $attributes
     * @return ModelInterface|ModelInterface[]
     */
    public function create(array $attributes = [])
    {
        return $this->transform($this->builder->create($attributes));
    }

    /**
     * Creates a collection of models.
     *
     * @param array $attributes
     * @return ModelInterface|ModelInterface[]
     */
    public function make(array $attributes = [])
    {
        return $this->transform($this->builder->make($attributes));
    }

    /**
     * Transforms a single table result (eloquent model) into the model.
     *
     * @param EloquentModel $eloquentModel
     * @return ModelInterface
     */
    private function model(EloquentModel $eloquentModel): ModelInterface
    {
        if ($closure = $this->closure) {
            return $closure($eloquentModel);
        }

        $model = $this->model;

        return new $model($eloquentModel->toArray());
    }

    /**
     * Transforms the table results (eloquent models) into models.
     *
     * @param EloquentModel|EloquentModel[] $result
     * @return ModelInterface|ModelInterface[]
     */
    private function transform($result)
    {
        if ($result instanceof EloquentModel) {
            return $this->model($result);
        }

        $results = [];

        foreach ($result as $eloquentModel) {
            $results[] = $this->model($eloquentModel);
        }

        return $results;
    }
}
