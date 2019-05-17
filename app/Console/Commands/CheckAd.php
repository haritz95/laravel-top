<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon;
use App\Ad;

class CheckAd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:ad';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if ad has ended or not.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = Carbon\Carbon::now();
        $ads = Ad::where('active', 1)->where('end_ad', '<=', $now)->get();

        foreach ($ads as $ad) {
            Ad::where('id', $ad->id)->update(['active' => 0]);
        }
    }
}
