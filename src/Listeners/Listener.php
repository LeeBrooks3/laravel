<?php

namespace LeeBrooks3\Laravel\Listeners;

use Illuminate\Contracts\Bus\Dispatcher as JobDispatcher;

abstract class Listener implements ListenerInterface
{
    /**
     * A job dispatcher instance.
     *
     * @var JobDispatcher
     */
    private $jobDispatcher;

    /**
     * @param JobDispatcher $jobDispatcher
     */
    public function __construct(JobDispatcher $jobDispatcher)
    {
        $this->jobDispatcher = $jobDispatcher;
    }
}
