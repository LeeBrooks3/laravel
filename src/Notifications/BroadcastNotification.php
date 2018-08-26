<?php

namespace LeeBrooks3\Laravel\Notifications;

interface BroadcastNotification extends NotificationInterface
{
    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable) : array;
}
