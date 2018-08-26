<?php

namespace LeeBrooks3\Laravel\Tests;

use Illuminate\Container\Container;
use LeeBrooks3\Tests\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    /**
     * The container instance.
     *
     * @var Container
     */
    protected $app;

    /**
     * Sets up the tests.
     */
    public function setUp()
    {
        parent::setUp();

        $this->createApplication();
    }

    /**
     * Sets up the application/container.
     */
    protected function createApplication()
    {
        $this->app = Container::getInstance();
    }
}
