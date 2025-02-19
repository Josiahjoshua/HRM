<?php

namespace App\Console\Commands;

use App\Models\Carcuss;
use App\Models\Cattle;
use App\Models\Cdm;
use App\Models\User;
use App\Models\Weight;
use App\Notifications\WeightCheckNotification;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class WeightCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weight:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Weekly cattle weight check notification generator';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cattle_ids = Weight::query()
        ->select('cattle_id')
        ->whereIn('id', Weight::query()->selectRaw("MAX(id) id")->groupBy('cattle_id'))
        ->where('created_at', '<=', now()->endOfDay()->subDays(15));
       

        $cattleNeedWeightCheck = Cattle::query()->whereIn('id', $cattle_ids) ->where('status', 1)->get();
        
        $this->info($cattleNeedWeightCheck);
        
        if(!$cattleNeedWeightCheck->count()){
            return;
        }

        // $users = User::query()->permission('view feedlot')->get();
        $users = User::query()->limit(1)->get();

        $users->each(fn($user)=> $user->notify(new WeightCheckNotification($cattleNeedWeightCheck)));

        return Command::SUCCESS;

      
    }
}
