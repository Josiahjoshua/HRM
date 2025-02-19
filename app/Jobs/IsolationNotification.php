<?php

namespace App\Jobs;

use App\Mail\CattleWeightReminder;
use App\Models\CattleAdded;
use App\Models\Isolation;
use Spatie\Permission\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Notifications\IsolationNotifications; 

class IsolationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $days = Isolation::select('days','tag')->first();
        $cattle = CattleAdded::select('tag')->where('tag', '=', $days->tag)->where('status','=','2')->get();
        $adminRole = Role::where('name', 'admin')->first();
        $admins = $adminRole->users;
                
        foreach ($admins as $admin) {
            $admin->notify(new IsolationNotifications($cattle,$days));        
        }
     
    }
}
