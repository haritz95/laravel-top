<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sites;
use App\Status;
use App\User;
use App\Roles;
use App\Ad;
use DB;
use Response;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $sites = Sites::simplePaginate(15);
        $status =  Status::all();
        $categories = DB::table('categories')->get();
        $users = User::all();    

        return view('admin.index', compact('sites', 'status', 'categories', 'users'));
    }

    public function changeStatus(Request $request, $id){

    	$status = $request['status'];

	    Sites::findOrFail($id)->update(['status_id' => $status]);     	

    	return redirect()->back()->with('message', 'Site updated.');
    }

    public function users()
    {
        $users = User::simplePaginate(15);
        $status =  Status::all();
        $roles = Roles::all();    

        return view('admin.users', compact('users', 'status', 'roles'));
    }

    public function changeStatusAd(Request $request, $id){

	    Ad::findOrFail($id)->update(['active' => $request['approve']]);     	

    	return redirect()->back()->with('message', 'Ad updated.');
    }

    public function ads()
    {
        $my_ads = Ad::with('spots')->get();
        $status =  Status::all();

        return view('admin.ads', compact('my_ads', 'status'));
    }

    public function banUser(Request $request, $id){

    	$user = DB::table('ban_reasons')->where('user_id', $id)->where('finished', 0)->orderBy('expire_date', 'desc')->get();

    	if($user->count()){
    		DB::table('ban_reasons')->where('user_id', $id)->where('finished', 0)->update([
                'reason' => request('reason'),
            	'expire_date' => request('expire_day')]);
    	}else{
    		DB::table('ban_reasons')->insert([
                'user_id' => $id,
                'reason' => request('reason'),
            	'expire_date' => request('expire_day')]);
    	}

    	$sites = Sites::where('user_id', $id)->get();

    	foreach ($sites as $site) {
    		$site->status_id = 2;
    		$site->save();
    	}
    	
    	User::where('id', $id)
    		->update(['status_id' => 2]);

    	return redirect()->back()->with('message', 'User updated.');
    }

    public function unbanUser($id){

    	DB::table('ban_reasons')->where('user_id', $id)->update([
                'finished' => 1]);

    	User::where('id', $id)
    	->update(['status_id' => 1]);

    	$sites = Sites::where('user_id', $id)->get();

    	foreach ($sites as $site) {
    		$site->status_id = 1;
    		$site->save();
    	}

    	return redirect()->back()->with('message', 'User updated.');
    }

    public function userInfo($id){

    	$user_info = DB::table('ban_reasons')->where('user_id', $id)->where('finished', 0)->orderBy('expire_date', 'desc')->get();

    	return $user_info;

    }

    public function user($id){

    	$user = User::findOrFail($id);

    	return $user;
    }

    public function userUpdate(Request $request, $id){

    	$user = User::findOrFail($id);

    	if (!$request->has('password')) {
		    $request->except(['password']); 
		}

		DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => request('name'),
                'email' => request('email'),
                'role_id' => request('role'),
                'status_id' => request('status'),
                'premium' => request('premium'),
                'end_premium' => request('premium_date'),
            ]);

    	return redirect()->back()->with('message', 'User updated.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->back()->with('message', 'User deleted.');
    }

    protected function createUser(Request $data)
    {
    	DB::table('users')->insert([
    		'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => $data['role'],
            'status_id' => $data['status'],
            'premium' => $data['premium'],
            'end_premium' => $data['premium_date'],
            'password' => Hash::make($data['password']),
    	]);

        return redirect()->back()->with('message', 'User created.');
    }

    public function checkEmail(Request $request){

    	if(User::where('email', $request['email'])->first()){
    		return "This E-mail already exists";
    	}else{
    		
    	}
    }
}
