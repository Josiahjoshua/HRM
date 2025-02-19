<?php

namespace App\Mail;

use App\Models\CattleAdded;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CattleWeightReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $cattle;

    public function __construct($cattle)
    {
        $this->cattle = $cattle;
    }

    public function build()
    {
        return $this->markdown('emails.cattle-weight-reminder');
    }
}