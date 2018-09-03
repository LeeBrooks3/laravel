<?php

namespace LeeBrooks3\Laravel\Listeners;

use LeeBrooks3\Laravel\Events\Event;

interface ListenerInterface
{
    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */
    public function handle(Event $event) : void;
}
