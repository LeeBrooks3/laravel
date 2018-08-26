<?php

namespace LeeBrooks3\Laravel\Tests\Functional\Listeners;

use Illuminate\Contracts\Bus\Dispatcher as JobDispatcher;
use Illuminate\Contracts\Foundation\Application;
use LeeBrooks3\Laravel\Listeners\SetsModelUuid;
use LeeBrooks3\Laravel\Tests\Examples\Events\ExampleModelEvent;
use LeeBrooks3\Laravel\Tests\Examples\Models\ExampleModel;
use LeeBrooks3\Laravel\Tests\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class SetsModelUuidTest extends TestCase
{
    /**
     * The listener instance.
     *
     * @var SetsModelUuid
     */
    private $listener;

    /**
     * Creates the listener instance.
     */
    public function setUp()
    {
        parent::setUp();

        $this->app->instance(JobDispatcher::class, $this->createMock(JobDispatcher::class));

        $this->listener = $this->app->make(SetsModelUuid::class);
    }

    /**
     * Tests that the model uuid is set.
     */
    public function testSetsModelUuid()
    {
        /** @var Application|MockObject $mockApp */
        $mockApp = $this->createMock(Application::class);
        $model = new ExampleModel();
        $event = new ExampleModelEvent($model);

        $this->listener->handle($event, $mockApp);

        $this->assertArrayHasKey('uuid', $model->getAttributes());
    }
}
