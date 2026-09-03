<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicantStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly string $eventType,
        private readonly string $title,
        private readonly string $message,
        private readonly ?string $actionUrl = null,
        private readonly ?int $applicationId = null,
        private readonly string $priority = 'normal',
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->eventType,
            'title' => $this->title,
            'message' => $this->message,
            'action_url' => $this->actionUrl,
            'application_id' => $this->applicationId,
            'priority' => $this->priority,
        ];
    }
}
