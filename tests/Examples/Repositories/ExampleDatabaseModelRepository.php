<?php

namespace LeeBrooks3\Laravel\Tests\Examples\Repositories;

use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use LeeBrooks3\Laravel\Events\ModelEvent;
use LeeBrooks3\Laravel\Repositories\Database\ModelRepository as DatabaseModelRepository;
use LeeBrooks3\Laravel\Tests\Examples\Database\ExampleDatabaseTable;
use LeeBrooks3\Laravel\Tests\Examples\Events\ExampleModelEvent;
use LeeBrooks3\Laravel\Tests\Examples\Models\ExampleModel;

class ExampleDatabaseModelRepository extends DatabaseModelRepository
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected $model = ExampleModel::class;

    /**
     * {@inheritdoc}
     *
     * @var array
     */
    protected $events = [
        ModelEvent::CREATING => ExampleModelEvent::class,
    ];

    /**
     * @param ExampleDatabaseTable $table
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(ExampleDatabaseTable $table, EventDispatcher $eventDispatcher)
    {
        parent::__construct($table, $eventDispatcher);
    }
}
