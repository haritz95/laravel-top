<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class CountVotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'count:votes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and add votes to sites.';

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
        $votes = DB::table('table_votes')->where('counted', 0)->get();

        $user_info = DB::table('table_votes')
                 ->select('site_id', DB::raw('count(*) as total'))
                 ->where('counted', 0)
                 ->groupBy('site_id')
                 ->get();

        foreach ($user_info as $user) {

            $vote_id= DB::table('table_votes')->where('site_id', $user->site_id)->get();

            $current_votes = DB::table('sites')->where('status_id', '!=', 0)->where('id', $user->site_id)->first();
            $current_votes = $current_votes->votes;
            $total_votes = $current_votes + $user->total;

            DB::table('sites')->where('id', $user->site_id)->update(array('votes' => $total_votes));

            foreach ($vote_id as $vote) {
                DB::table('table_votes')->where('id', $vote->id)->update(array('counted' => 1));
            }
            
        }

    }
}
