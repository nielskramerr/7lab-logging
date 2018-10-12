<?php

namespace SevenLabLogging\Notifications;

use Spatie\FailedJobMonitor\Notification;

class SevenLabFailedJobNotification extends Notification
{

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDashboard($notifiable)
    {
        return [
            'Exception message' => $this->event->exception->getMessage(),
            'Job class' => $this->event->job->resolveName(),
            'Job body' => $this->event->job->getRawBody(),
            'Exception' => $this->event->exception->getTraceAsString(),
        ];
    }
}
