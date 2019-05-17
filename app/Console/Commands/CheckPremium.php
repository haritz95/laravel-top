<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Carbon;

class CheckPremium extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:premium';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if premium has end or not.';

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
        /*$sites = DB::table('sites')->where('end_premium', '<=', $now)->where('premium', 1)->get();*/
        $users = DB::table('users')->where('end_premium', '<=', $now)->where('premium', 1)->get();

        /*foreach ($sites as $site) {
            DB::table('sites')->where('id', $site->id)->update(array('premium' => 0, 'end_premium' => NULL));
        }*/
        foreach ($users as $user) {
            DB::table('users')->where('id', $user->id)->update(array('premium' => 0, 'end_premium' => NULL));
            DB::table('sites')->where('user_id', $user->id)->update(array('premium' => 0, 'end_premium' => NULL));
        }
    }
}
