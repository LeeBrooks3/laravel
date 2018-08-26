<?php

namespace LeeBrooks3\Laravel\Tests\Unit\Repositories;

use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use LeeBrooks3\Laravel\Tests\Examples\Repositories\ExampleApiModelRepository;
use LeeBrooks3\Tests\Unit\Repositories\ApiModelRepositoryTest as BaseApiModelRepositoryTest;
use PHPUnit\Framework\MockObject\MockObject;

class ApiModelRepositoryTest extends BaseApiModelRepositoryTest
{
    /**
     * A mocked event dispatcher instance.
     *
     * @var EventDispatcher|MockObject
     */
    protected $mockEventDispatcher;

    /**
     * Creates a mock client instance and an instance of the repository.
     */
    public function setUp()
    {
        parent::setUp();

        $this->mockEventDispatcher = $this->createMock(EventDispatcher::class);

        $this->repository = new ExampleApiModelRepository($this->mockClient, $this->mockEventDispatcher);
    }
}
