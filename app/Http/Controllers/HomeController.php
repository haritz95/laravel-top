<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sites;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $sites = DB::table('sites')->where('status_id', '!=', 0)->orderBy('votes','desc')->simplePaginate(15);

        return view('sites.index', compact('sites'));
    }
}
