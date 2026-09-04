<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
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
        return $this->eventType === 'application_returned'
            ? ['database', 'mail']
            : ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $applicantName = trim((string) ($notifiable->first_name ?? ''));
        $actionUrl = $this->actionUrl
            ? url($this->actionUrl)
            : route('applicant.track-status');

        return (new MailMessage)
            ->subject('NCIP Application Returned for Correction')
            ->greeting($applicantName !== '' ? "Hello {$applicantName}," : 'Hello,')
            ->line($this->message)
            ->action('Review Application', $actionUrl)
            ->line('Please review the staff remarks, correct the returned document or section, and resubmit your application.');
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
