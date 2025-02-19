<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\PerdeimRetire;

class PerdeimRetirementRejected extends Notification
{
    use Queueable;

    protected $perdeim;
    protected $approverName;
    protected $rejectionReason;
    protected $fromAddress;

    public function __construct(PerdeimRetire $perdeim, $approverName, $rejectionReason, $fromAddress)
    {
        $this->perdeim = $perdeim;
        $this->approverName = $approverName;
        $this->rejectionReason = $rejectionReason;
        $this->fromAddress = $fromAddress;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail']; // Specify the delivery channel(s) here, for example, 'mail'
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
            ->from($this->fromAddress)
            ->line('Your Perdeim retirement application has been rejected by '.$this->approverName.'.')
            ->line('Rejection Reason: '.$this->rejectionReason);
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
            //
        ];
    }
}


