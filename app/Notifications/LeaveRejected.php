<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Leave_application;
class LeaveRejected extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $approverName;

    /**
     * The rejection reason.
     *
     * @var string
     */
    protected $rejectionReason;
    protected $fromAddress;
    protected $leave;
   public function __construct(Leave_application $leave, $approverName, $rejectionReason, $fromAddress)
{
    $this->leave = $leave;
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
         ->line('Your leave application has been rejected by '.$this->approverName)
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
