<?php

namespace LeeBrooks3\Laravel\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification as BaseNotification;

abstract class Notification extends BaseNotification implements NotificationInterface
{
    use Queueable;
}
