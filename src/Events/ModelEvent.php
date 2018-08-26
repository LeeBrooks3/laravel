<?php

namespace LeeBrooks3\Laravel\Events;

use LeeBrooks3\Laravel\Events\Event as BaseEvent;
use LeeBrooks3\Models\ModelInterface;

abstract class ModelEvent extends BaseEvent
{
    /**
     * The different types of model events.
     */
    const CREATING = 'creating';
    const CREATED = 'created';
    const UPDATING = 'updating';
    const UPDATED = 'updated';
    const DELETING = 'deleting';
    const DELETED = 'deleted';
    const RESTORING = 'restoring';
    const RESTORED = 'restored';

    /**
     * The model instance.
     *
     * @var ModelInterface
     */
    protected $model;

    /**
     * @param ModelInterface $model
     */
    public function __construct(ModelInterface $model)
    {
        $this->model = $model;
    }

    /**
     * Returns the model instance.
     *
     * @return ModelInterface
     */
    public function getModel() : ModelInterface
    {
        return $this->model;
    }
}
