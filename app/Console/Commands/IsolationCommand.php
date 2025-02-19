<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use Illuminate\Console\Command;

class IsolationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'isolation:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cattle_ids = Doctor::query()
        ->select('cattle_id')
        ->whereIn('id', Doctor::query()->selectRaw("MAX(id) id")->groupBy('cattle_id'))
        ->where('end_date', '<=', now()->subDay()->toDateString());

        $cattleIsolationCheck= Cattle::query()->whereIn('id', $cattle_ids)->whereNull('status')->get();
        
        $this->info($cattleIsolationCheck);
        
        if(!$cattleIsolationCheck->count()){
            return;
        }

        // $users = User::query()->permission('view feedlot')->get();
        $users = User::query()->limit(1)->get();

        $users->each(fn($user)=> $user->notify(new IsolationNotification($cattleIsolationCheck)));
        return Command::SUCCESS;
    }
}
