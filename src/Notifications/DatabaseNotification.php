<?php

namespace LeeBrooks3\Laravel\Notifications;

interface DatabaseNotification extends NotificationInterface
{
    /**
     * Get the database representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable) : array ;
}
