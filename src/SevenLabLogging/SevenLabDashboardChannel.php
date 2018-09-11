<?php

namespace SevenLabLogging\Channels;

use Illuminate\Notifications\Notification;

class SevenLabDashboardChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDashboard($notifiable);

        if (app()->bound('7lab-logging')) {
            app('7lab-logging')->sendFaildJob($data);
        }

    }
}
