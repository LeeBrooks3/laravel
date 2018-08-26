<?php

namespace LeeBrooks3\Laravel\Repositories\Database;

use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use LeeBrooks3\Laravel\Database\Table;
use LeeBrooks3\Laravel\Events\ModelEvent;
use LeeBrooks3\Models\ModelInterface;
use LeeBrooks3\Repositories\ModelRepository as BaseModelRepository;

abstract class ModelRepository extends BaseModelRepository
{
    /**
     * An event dispatcher instance.
     *
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * The table instance.
     *
     * @var Table
     */
    private $table;

    /**
     * The model events this dispatches.
     *
     * @var array
     */
    protected $events = [];

    /**
     * @param Table $table
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(Table $table, EventDispatcher $eventDispatcher)
    {
        $this->table = $table;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $params
     * @return ModelInterface[]
     */
    public function get(array $params = []) : array
    {
        return $this->getTable()
            ->newQuery()
            ->where($params)
            ->get()
            ->map(function (Table $result) {
                return $this->model($result->toArray());
            })
            ->all();
    }

    /**
     * {@inheritdoc}
     *
     * @param array $attributes
     * @return ModelInterface
     */
    public function create(array $attributes = []) : ModelInterface
    {
        $model = $this->model($attributes);

        $this->dispatchEvent($model, ModelEvent::CREATING);

        /** @var Table $result */
        $result = $this->getTable()
            ->newQuery()
            ->create($attributes);

        $model = $this->model($result->toArray());

        $this->dispatchEvent($model, ModelEvent::CREATED);

        return $model;
    }

    /**
     * {@inheritdoc}
     *
     * @param int|string $id
     * @param array $params
     * @return ModelInterface
     */
    public function find($id, array $params = []) : ModelInterface
    {
        $model = $this->model();

        $primaryKey = $model->getKeyName();
        $routeKey = $model->getRouteKeyName();

        $query = $this->getTable()
            ->newQuery()
            ->where($primaryKey, $id);

        if ($primaryKey !== $routeKey) {
            $query->orWhere($routeKey, $id);
        }

        $result = $query->firstOrFail();

        return $this->model($result->toArray());
    }

    /**
     * {@inheritdoc}
     *
     * @param ModelInterface $model
     * @param array $attributes
     * @return ModelInterface
     */
    public function update(ModelInterface $model, array $attributes = []) : ModelInterface
    {
        $model->fill($attributes);
        $changes = $model->getChangedAttributes();

        $primaryKey = $model->getKeyName();
        $primary = $model->getKey();

        $this->dispatchEvent($model, ModelEvent::UPDATING);

        $this->getTable()
            ->newQuery()
            ->where($primaryKey, $primary)
            ->update($changes);

        $this->dispatchEvent($model, ModelEvent::UPDATED);

        return $model;
    }

    /**
     * {@inheritdoc}
     *
     * @param ModelInterface $model
     * @return void
     */
    public function delete(ModelInterface $model) : void
    {
        $primaryKey = $model->getKeyName();
        $primary = $model->getKey();

        $this->dispatchEvent($model, ModelEvent::DELETING);

        $this->getTable()
            ->newQuery()
            ->where($primaryKey, $primary)
            ->delete();

        $this->dispatchEvent($model, ModelEvent::DELETED);
    }

    /**
     * Dispatches a model event.
     *
     * @param ModelInterface $model
     * @param string $type
     * @return void
     */
    protected function dispatchEvent(ModelInterface $model, string $type) : void
    {
        $eventClass = array_get($this->events, $type);

        if (!$eventClass) {
            return;
        }

        $event = new $eventClass($model);

        $this->eventDispatcher->dispatch($event);
    }

    /**
     * Returns the table (eloquent model) instance.
     *
     * @return Table
     */
    protected function getTable() : Table
    {
        return $this->table;
    }
}
