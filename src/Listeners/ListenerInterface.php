<?php

namespace LeeBrooks3\Laravel\Listeners;

use Illuminate\Contracts\Foundation\Application;
use LeeBrooks3\Laravel\Events\Event;

interface ListenerInterface
{
    /**
     * Handle the event.
     *
     * @param Event $event
     * @param Application|null $app
     * @return void
     */
    public function handle(Event $event, Application $app) : void;
}
