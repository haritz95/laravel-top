<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class UpdateRank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the rank of all sites.';

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
        $sites = DB::table('sites')->where('status_id', '!=', 1)->orderBy('votes', 'desc')->get();

        foreach ($sites as $indexKey => $site) {
            DB::table('sites')->where('id', $site->id)->update(array('rank' => $indexKey+1));
        }
    }
}
