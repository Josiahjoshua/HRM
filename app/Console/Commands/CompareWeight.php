<?php

namespace App\Console\Commands;
use App\Models\Cdm;
use App\Models\User;
use App\Models\Weight;
use App\Models\Carcuss;
use App\Notifications\WeightCompareNotification;
use Illuminate\Console\Command;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class CompareWeight extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'compare:weight';

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

        $totalCmd = Cdm::query()->select('postmo_id', DB::raw('SUM(cdm_weight) as total_cdm_weight'))
        ->groupBy('postmo_id');

        
        $weightCommpare = Carcuss::query()
        ->join('postmos', 'postmos.carcuss_id', '=','carcusses.id')
        ->joinSub($totalCmd, 'total_cdms', 'postmos.id', '=', 'total_cdms.postmo_id')
        ->whereRaw('(hdm_weight - total_cdm_weight) >=  5')
        ->get();
        
        $users = User::query()->limit(1)->get();

        $users->each(fn($user)=> $user->notify(new WeightCompareNotification($weightCommpare)));


        return Command::SUCCESS;
    }
}
