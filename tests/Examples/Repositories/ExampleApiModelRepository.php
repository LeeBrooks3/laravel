<?php

namespace LeeBrooks3\Laravel\Tests\Examples\Repositories;

use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use LeeBrooks3\Laravel\Events\ModelEvent;
use LeeBrooks3\Laravel\Repositories\Api\ModelRepository as ApiModelRepository;
use LeeBrooks3\Laravel\Tests\Examples\Events\ExampleModelEvent;
use LeeBrooks3\Tests\Examples\Http\Clients\ExampleClient;
use LeeBrooks3\Laravel\Tests\Examples\Models\ExampleModel;

class ExampleApiModelRepository extends ApiModelRepository
{
    /**
     * {@inheritdoc}
     *
     * @var string
     */
    protected $endpoint = 'example';

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
     * @param ExampleClient $client
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(ExampleClient $client, EventDispatcher $eventDispatcher)
    {
        parent::__construct($client, $eventDispatcher);
    }
}
