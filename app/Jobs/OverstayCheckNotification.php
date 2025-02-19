<?php

namespace App\Jobs;

use App\Mail\CattleWeightReminder;
use App\Models\CattleAdded;
use Spatie\Permission\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels; 
use Illuminate\Support\Facades\Mail;
use App\Notifications\OverstayCheckNotifications;


class OverstayCheckNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $cattles = CattleAdded::select('tag')->where('weight', '<', 310)->where('status','=','0')->get();
        $adminRole = Role::where('name', 'admin')->first();
        $admins = $adminRole->users;
                
        foreach ($admins as $admin) {
            $admin->notify(new OverstayCheckNotifications($cattles));
        }
     
    }

    
}
