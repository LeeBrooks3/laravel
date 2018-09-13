<?php

namespace LeeBrooks3\Laravel\Repositories\Api;

use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use LeeBrooks3\Http\Clients\ClientInterface;
use LeeBrooks3\Laravel\Events\ModelEvent;
use LeeBrooks3\Models\ModelInterface;
use LeeBrooks3\Repositories\Api\ModelRepository as BaseModelRepository;

abstract class ModelRepository extends BaseModelRepository
{
    /**
     * An event dispatcher instance.
     *
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * The model events this dispatches.
     *
     * @var array
     */
    protected $events = [];

    /**
     * @param ClientInterface $client
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(ClientInterface $client, EventDispatcher $eventDispatcher)
    {
        parent::__construct($client);

        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     * Also dispatches events when creating and created the resource.
     *
     * @param array $attributes
     * @return ModelInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(array $attributes = []) : ModelInterface
    {
        $model = $this->makeModel($attributes);

        $this->dispatchEvent($model, ModelEvent::CREATING);

        $model = parent::create($attributes);

        $this->dispatchEvent($model, ModelEvent::CREATED);

        return $model;
    }

    /**
     * {@inheritdoc}
     * Also dispatches events when updating and updated the resource.
     *
     * @param ModelInterface $model
     * @param array $attributes
     * @return ModelInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(ModelInterface $model, array $attributes = []) : ModelInterface
    {
        $model->fill($attributes);

        $this->dispatchEvent($model, ModelEvent::UPDATING);

        $model = parent::update($model, $attributes);

        $this->dispatchEvent($model, ModelEvent::UPDATED);

        return $model;
    }

    /**
     * {@inheritdoc}
     * Also dispatches events when deleting and deleted the resource.
     *
     * @param ModelInterface $model
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(ModelInterface $model) : void
    {
        $this->dispatchEvent($model, ModelEvent::DELETING);

        parent::delete($model);

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
}
