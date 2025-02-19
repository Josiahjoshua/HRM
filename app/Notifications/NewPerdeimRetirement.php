<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewPerdeimRetirement extends Notification
{
    use Queueable;

    protected $perdeim;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($perdeim)
    {
        $this->perdeim = $perdeim;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Perdeim Retirement')
            ->line(' perdeim retirememt has been submitted by '.$this->perdeim->user->name)
            ->action('View Retirement', url('/'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'perdeim_id' => $this->perdeim->id,
            'perdeim_employee' => $this->perdeim->employee->name,
            'perdeim_amount' => $this->perdeim->amount,
            'perdeim_reason' => $this->perdeim->reason,
        ];
    }
}
