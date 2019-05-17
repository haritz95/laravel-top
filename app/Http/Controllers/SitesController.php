<?php

namespace App\Http\Controllers;

use App\Sites;
use App\Category;
use App\Ad;
use App\User;
use Illuminate\Http\Request;
use DB;
use Carbon;
use Auth;
use Redirect;
use Session;
use Validator;
use URL;
use App\Http\Requests\SiteStoreRequest;
use App\Http\Requests\AdStoreRequest;
use App\Http\Requests\VoteStoreRequest;

class SitesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show', 'vote', 'storeVote']]);
        $this->middleware('banned');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = DB::table('sites')->where('status_id', 1)->orderBy('votes','desc')->simplePaginate(15)->status;
        $ads = Ad::inRandomOrder()->limit(6)->where('active', 1)->get();
        

        return view('sites.index', compact('sites', 'ads'));  
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
            //$rank = DB::table('sites')->select('rank')->orderBy('votes', 'asc')->orderBy('created_at', 'asc')->where('status_id', 1)->first();
            /*if(!$rank['rank']){
                $rank = 1;
            }*/

            if(Auth::user()->end_premium < Carbon\Carbon::now()){
                $premium = 0;
            }else{
                $premium = 1;
            }
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
                        //'rank' => $rank[rank]+1,
                        'premium' => $premium,
                        'user_id' => $user->id,
                        'url_file' => $url_file,
                        'created_at' => Carbon\Carbon::now(),
                        'updated_at' => Carbon\Carbon::now(),
                    ]); 

            return redirect()->back()->with('message', 'Site created.');      
            
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
        if($site->status_id == 1 || $site->user_id == Auth::id()){
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
        else{
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->admin()){
            $site = Sites::findOrFail($id);
            $user = $site->user;
            $categories = Category::all();
        }else{
            $site = Sites::where('user_id', Auth::user()->id)->findOrFail($id);
            $user = $site->user;
            $categories = Category::all();
        } 

        $users = User::all();

        return view('sites.edit', compact('site','user','categories', 'users'));
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

        if(Auth::user()->admin()){
            $site = Sites::findOrFail($id);

            $user = Auth::user();

            $owner = $user->id;

            if(request('owner') != null){
                $owner = request('owner');
            }

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
                    'user_id' => $owner,
            ]);

        }else{
            $site = Sites::where('user_id', Auth::user()->id)->findOrFail($id);

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
        }
        

        return redirect()->back()->with('message', 'Site updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sites  $sites
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->admin()){
            $site = Sites::findOrFail($id);

            $site->delete();

        }else{
            $site = Sites::where('user_id', Auth::user()->id)->findOrFail($id);

            $site->delete();
        }
        

        return redirect()->back()->with('message', 'Site deleted.');
    }

    public function vote($id)
    {
        $site = Sites::findOrFail($id);
        if($site->status_id != 1){
            return redirect()->back();
        }
        else{
            return view('sites.vote', compact('site'));
        }
        
    }

    public function storeVote(VoteStoreRequest $request, $id)
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
        $ad_spots = DB::table('table_ad_spots')->where('active', 1)->get();
        $ad_period = DB::table('table_ads_period')->get();
        $my_ads = Ad::with('spots')->where('user_id', $user->id)->get();


        return view('sites.dashboard', compact('sites', 'ad_spots', 'ad_period', 'my_ads'));
    }

    public function myAccount()
    {
        return view('account.index');
    }

    public function myAds()
    {
        $user = Auth::user();
        $my_ads = Ad::with('spots')->where('user_id', $user->id)->get();
        return view('ads.index', compact('my_ads'));
    }

    public function adCreate()
    {
        $ad_spots = DB::table('table_ad_spots')->where('active', 1)->get();
        $ad_period = DB::table('table_ads_period')->get();

        return view('ads.create', compact('ad_spots', 'ad_period'));
    }

    public function storeAd(AdStoreRequest $request)
    {
        $user = Auth::user();
        $now = Carbon\Carbon::now();        

            if(request('banner_link') == ""){
                $file = $request->file('banner');
                $destinationPath = 'images/'.$user->name;
                $file->move($destinationPath,$file->getClientOriginalName());
                $url_file = $destinationPath.'/'.$file->getClientOriginalName();
                $banner = $url_file;
            }else{
                $banner = request('banner_link');
            }
             $data = DB::table('ads')->insert([
                'id_spot' => request('spot'),
                'id_period' => request('days'),
                'tittle' => request('tittle'),
                'website' => request('website'),
                'banner' => $banner,
                'active' => 0,
                'user_id' => Auth::user()->id,
                'created_at' => $now,
                'updated_at' => $now]);

             return redirect()->back()->with('message', 'Ad created.');
    }

    public function clickAd($id)
    {
        $ad = Ad::findorfail($id); // Find our post by ID.
        $ad->increment('clicks'); // Increment the value in the clicks column.
        $ad->update(); // Save our updated post.
    }

    public function destroyAd($id)
    {
        $ad = Ad::findOrFail($id);

        $ad->delete();

        return redirect()->back()->with('message', 'Ad deleted.');
    }

    public function editAd($id)
    {
        $ad = Ad::findOrFail($id);
        $ad_spots = DB::table('table_ad_spots')->where('active', 1)->get();
        $ad_period = DB::table('table_ads_period')->get();

        return view('ads.edit', compact('ad', 'ad_spots', 'ad_period'));  
    }

    public function updateAd(Request $request, $id)
    {

        $now = Carbon\Carbon::now();

            if(DB::table('ads')->select('banner')->get()){
                $data = DB::table('ads')->where('id',$id)->update([
                'id_spot' => request('spot'),
                'id_period' => request('days'),
                'tittle' => request('tittle'),
                'website' => request('website'),
                'updated_at' => $now]);
            }else{
                $data = DB::table('ads')->where('id',$id)->update([
                'id_spot' => request('spot'),
                'id_period' => request('days'),
                'tittle' => request('tittle'),
                'website' => request('website'),
                'banner' => $banner,
                'updated_at' => $now]);
            }
             return redirect()->back()->with('message', 'Ad updated.');
    }

    public function previewAd($id)
    {
        $sites = Sites::where('status_id', 1)->orderBy('votes','desc')->simplePaginate(15);
        $ad = Ad::findorfail($id)->where('id', $id)->first();        

        return view('ads.preview', compact('sites', 'ad')); 
    }

    public function categories(){
        $categories = Category::all();
        return view('admin.categories', compact('categories'));
    }

    public function createCategory(Request $request){

        $category = new Category;
        if($request->file("banner")){
            $file = $request->file('banner');
                $destinationPath = 'images/category/'.$request->category;
                $file->move($destinationPath,$file->getClientOriginalName());
                $url_file = URL::to("/").'/'.$destinationPath.'/'.$file->getClientOriginalName();

        }else{
            $url_file = $request->banner_link;
        }
        


        $category->name = $request->category;
        $category->image = $url_file;

        $category->save();

        return redirect()->back()->with('message', 'Category created.');
    }

    public function updateCategory(Request $request,$id)
    {
        $category = Category::findOrFail($id);

        if($request->file("banner")){
            $file = $request->file('banner');
                $destinationPath = 'images/category/'.$request->category;
                $file->move($destinationPath,$file->getClientOriginalName());
                $url_file = URL::to("/").'/'.$destinationPath.'/'.$file->getClientOriginalName();
        }else{
            $url_file = $request->banner_link;
        }

        

        $category->name = $request->name;
        $category->image = $url_file;

        $category->save();

        return redirect()->back()->with('message', 'Category updated.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return redirect()->back()->with('message', 'Category deleted.');
    }
    public function checkCategory(Request $request)
    {
        $category = DB::table('categories')->where('name', $request->category)->get();

        if($category->count()){
            return "ok";
        }

    }

    public function premium(){

        $premium = DB::table('premium_period')->get();

        return view('admin.premium', compact('premium'));
    }

    public function createPremium(Request $request){

        $now = Carbon\Carbon::now();

        $data = DB::table('premium_period')->insert([
                'display_name' => request('name'),
                'days' => request('days'),
                'price' => request('price'),
                'discount_percentage' => request('discount'),
                'created_at' => $now,
                'updated_at' => $now]);
        

        return redirect()->back()->with('message', 'Plan created.');
    }
 
}
