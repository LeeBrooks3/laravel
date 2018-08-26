<?php

namespace LeeBrooks3\Laravel\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

interface MailNotification extends NotificationInterface
{
    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable) : MailMessage;
}
