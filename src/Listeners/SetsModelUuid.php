<?php

namespace LeeBrooks3\Laravel\Listeners;

use LeeBrooks3\Laravel\Events\Event;
use Ramsey\Uuid\Uuid;

class SetsModelUuid extends Listener
{
    /**
     * Sets the models uuid attribute.
     *
     * @param Event|\LeeBrooks3\Laravel\Events\ModelEvent $event
     * @return void
     * @throws \Exception
     */
    public function handle(Event $event) : void
    {
        $model = $event->getModel();

        if (!isset($model->uuid)) {
            $model->uuid = (string) Uuid::uuid4();
        }
    }
}
