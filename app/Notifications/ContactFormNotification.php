<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactFormNotification extends Notification
{
    use Queueable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('📬 A Visitor Wants to Connect – New Message Received!')
            ->greeting('Hello Admin! 👋')
            ->line('You have received a new message from the Contact Us form. 🎉')
            ->line('✨ **Sender Details:**')
            ->line('📝 Name: ' . $this->data['name'])
            ->line('📧 Email: ' . $this->data['email'])
            ->line('📞 Phone: ' . $this->data['phone'])
            ->line('📰 Subject: ' . $this->data['subject'])
            ->line('💬 Message: ' . $this->data['message'])
            ->line('----------------------------------')
            ->line('Please respond promptly to keep your visitors happy! 😊')
            ->salutation('Cheers, 🖖 Hyper Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
