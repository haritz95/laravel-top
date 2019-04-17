<?php

namespace App\Http\Controllers;

use App\Sites;
use Request;
use DB;
use Carbon;

class SitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = DB::table('sites')->where('status_id', '!=', 0)->orderBy('votes','desc')->simplePaginate(15);

        return view('sites.test', compact('sites'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $site = Sites::findOrFail($id);
        $user = $site->user;

        return view('sites.view', compact('site','user'));  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function edit(Sites $sites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sites $sites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sites $sites)
    {
        //
    }

    public function vote($id)
    {
        $site = Sites::findOrFail($id);
        return view('sites.vote', compact('site'));
    }

    public function storeVote(Request $request)
    {
        $ip = Request::ip();
        $now = Carbon\Carbon::now();

        $votes = DB::table('table_votes')->where('ip', $ip)->where('site_id', request('site_id'))->orderBy('created_at', 'asc')->first();

        if(!$votes){
            $inserted = DB::table('table_votes')
                    ->insert([
                        'site_id' => request('site_id'),
                        'ip' => $ip,
                        'created_at' => $now,
                        'counted' => 0
                    ]);
                    $message = 'Thanks for your vote';
        }else{
            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $votes->created_at);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $now);
            $diff_in_hours = $to->diffInHours($from);
            if($diff_in_hours >= 12){
                DB::table('table_votes')->where('id', $votes->id)->delete();
                $inserted = DB::table('table_votes')
                    ->insert([
                        'site_id' => request('site_id'),
                        'ip' => $ip,
                        'created_at' => $now,
                        'counted' => 0
                    ]);
                    $message = 'Thanks for your vote';
            }else{
                $message = 'You can not vote yet';
            }
            
        }

        return redirect()->action('SitesController@show', ['id' => request('site_id')])->with('message', $message);
    }
}
