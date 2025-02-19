<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Perdeim;

class PerdeimApplicationRejected extends Notification
{
    use Queueable;

    /**
     * The Perdeim instance.
     *
     * @var \App\Models\Perdeim
     */
    protected $perdeim;

    /**
     * The name of the approver.
     *
     * @var string
     */
    protected $approverName;

    /**
     * The rejection reason.
     *
     * @var string
     */
    protected $rejectionReason;
    protected $fromAddress;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Perdeim $perdeim, $approverName, $rejectionReason, $fromAddress)
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
        ->from($this->fromAddress)
            ->line('Your Perdiem application has been rejected by '.$this->approverName.'.')
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
