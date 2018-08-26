<?php

namespace LeeBrooks3\Laravel\Notifications;

interface NotificationInterface
{
    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable) : array;
}
