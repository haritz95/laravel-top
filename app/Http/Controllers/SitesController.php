<?php

namespace App\Http\Controllers;

use App\Sites;
use App\Category;
use Illuminate\Http\Request;
use DB;
use Carbon;
use Auth;
use Redirect;
use Session;
use Validator;
use App\Http\Requests\SiteStoreRequest;

class SitesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show', 'vote', 'storeVote']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = DB::table('sites')->where('status_id', 1)->orderBy('votes','desc')->simplePaginate(15);

        return view('sites.index', compact('sites'));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('sites.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteStoreRequest $request)
    {
        $url = request('website');
        $parse = parse_url($url);
        if(request('tags')){
            $tags = request('tags');
            $tags = (implode($tags,','));
        }else{
            $tags = "";
        }
        
        $check_site = DB::table('sites')->where('url', 'like', '%'. $parse['host'] . '%')->get();

        if(count($check_site)){
             return Redirect::back()->with('message', 'This Server alredy exists.');
        }else{
            $user = Auth::user();
            if($request->file('banner')){
                $file = $request->file('banner');
                $destinationPath = 'images/'.$user->name;
                $file->move($destinationPath,$file->getClientOriginalName());
                $url_file = $destinationPath.'/'.$file->getClientOriginalName();
            }else{
                $url_file = "";   
            }

            /*------ THIS I WILL USE IT WHEN THE SITE IS ACTIVATED. IT WILL AUTOMATICALLY GET A RANK --------*/
            /*$rank = DB::table('sites')->select('rank')->orderBy('votes', 'asc')->orderBy('created_at', 'asc')->where('status_id', 1)->first();
            if(!$rank->rank){
                $rank = 1;
            }*/

            $data = DB::table('sites')
                    ->insert([
                        'title' => request('title'),
                        'description' => request('description'),
                        'p_description' => request('p_description'),
                        'url' => request('website'),
                        'category_id' => request('category'),
                        'tags' => $tags,
                        'status_id' => 3,
                        'votes' => 0,
                        //'rank' => $rank->rank+1,
                        'user_id' => $user->id,
                        'url_file' => $url_file,
                        'created_at' => Carbon\Carbon::now(),
                        'updated_at' => Carbon\Carbon::now(),
                    ]); 

             return redirect('/');       
        }
        
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

        $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 350])
        ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October' , 'November' ,'December'])
        ->datasets([
            [
                "label" => "Votes",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => [65, 59, 80, 81, 56, 55, 40],
            ],
            [
                "label" => "Visits",
                'backgroundColor' => "rgba(233, 67, 67, 0.8)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => [12, 33, 44, 44, 55, 23, 40],
            ]
        ])
        ->options([]);

        return view('sites.view', compact('site','user','chartjs'));  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $site = Sites::findOrFail($id);
        $user = $site->user;
        $categories = Category::all();

        return view('sites.edit', compact('site','user','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function update(SiteStoreRequest $request, $id)
    {
        $site = Sites::findOrFail($id);

        $user = Auth::user();

        if(request('tags')){
            $tags = request('tags');
            $tags = (implode($tags,','));
        }else{
            $tags = "";
        }
        if($request->file('banner')){
            $file = $request->file('banner');
            $destinationPath = 'images/'.$user->name;
            $file->move($destinationPath,$file->getClientOriginalName());
            $url_file = $destinationPath.'/'.$file->getClientOriginalName();
        }else{
            $url_file = $site->url_file;   
        }        

        DB::table('sites')
            ->where('id', $id)
            ->update([
                'title' => request('title'),
                'description' => request('description'),
                'p_description' => request('p_description'),
                'category_id' => request('category'),
                'url' => request('website'),
                'url_file' => $url_file,
                'tags' => $tags,
        ]);

        Session::flash('flash_message', 'Task successfully added!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Sites::findOrFail($id);

        $user->delete();

        return redirect()->back();
    }

    public function vote($id)
    {
        $site = Sites::findOrFail($id);
        return view('sites.vote', compact('site'));
    }

    public function storeVote(Request $request, $id)
    {   

        if (Sites::find($id)) {
            $site_id = $id;
            $ip = \Request::getClientIp();
            $now = Carbon\Carbon::now();

            $votes = DB::table('table_votes')->where('ip', $ip)->where('site_id', $site_id)->orderBy('created_at', 'desc')->first();

            if(!$votes){
                $inserted = DB::table('table_votes')
                        ->insert([
                            'site_id' => $site_id,
                            'ip' => $ip,
                            'created_at' => $now,
                            'counted' => 0
                        ]);
                        $message = 'Thanks for your vote.';
            }else{
                $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $votes->created_at);
                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $now);
                $diff_in_hours = $to->diffInHours($from);

                if($diff_in_hours >= 12){
                    //DB::table('table_votes')->where('id', $votes->id)->delete();
                    $inserted = DB::table('table_votes')
                        ->insert([
                            'site_id' => $site_id,
                            'ip' => $ip,
                            'created_at' => $now,
                            'counted' => 0
                        ]);
                        $message = 'Thanks for your vote.';
                }else{
                    $message = 'You can not vote yet';
                }
                
            }

            return redirect()->action('SitesController@show', ['id' => $site_id])->with('message', $message);

        }else{
            $message = "There was an error. Try again.";
            return Redirect::back()->with('message', $message);
        } 
    }

    public function storeVisit(Request $request)
    {
        $ip = \Request::getClientIp();
        $now = Carbon\Carbon::now();
        $inserted = DB::table('table_visits')
                        ->insert([
                            'site_id' => request('site'),
                            'ip' => $ip,
                            'created_at' => $now,
                        ]);
    }


    public function dashboard()
    {
        $user = Auth::user();
        $sites = Sites::with('category')->where('user_id', $user->id)->get();

        //dd($sites);

        return view('sites.dashboard', compact('sites'));
    }
}
