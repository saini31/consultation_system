<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConsultationScheduled extends Notification implements ShouldQueue
{
    use Queueable;

    protected $consultation;

    /**
     * Create a new notification instance.
     *
     * @param $consultation
     * @return void
     */
    public function __construct($consultation)
    {
        $this->consultation = $consultation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Consultation Scheduled')
            ->line('A new consultation has been scheduled.')
            ->line('User ID: ' . $this->consultation['user_id'])
            ->line('Professional ID: ' . $this->consultation['professional_id'])
            ->line('Scheduled At: ' . $this->consultation['scheduled_at'])
            ->line('Notes: ' . $this->consultation['notes'])
            ->action('View Consultation', url('/consultations/' . $this->consultation['id']));
    }
}
