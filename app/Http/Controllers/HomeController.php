<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; 
use App\Sites;
use App\Ad;
use DB;
use Auth;
use Validator;
use Hash;
use Redirect;


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

        $sites = Sites::where('status_id', 1)->orderBy('votes','desc')->simplePaginate(15);
        $ads = Ad::inRandomOrder()->limit(6)->where('active', 1)->get();

        $this->storeVisit($ads);

        return view('sites.index', compact('sites', 'ads'));
    }

    public function storeVisit($data)
    {
      foreach ($data as $ad_info) {
        $ad = Ad::findorfail($ad_info->id); // Find our post by ID.
        $ad->increment('views'); // Increment the value in the clicks column.
        $ad->update(); // Save our updated post.
      }
       
    }

    public function admin_credential_rules(array $data)
    {
      $messages = [
        'current.required' => 'Please enter current password',
        'password.required' => 'Please enter the new password',
      ];

      $validator = Validator::make($data, [
        'current' => 'required|min:8',
        'password' => 'required|same:password|min:8',
        'confirmation' => 'required|same:password|min:8',     
      ], $messages);

      return $validator;
    }  

    public function postCredentials(Request $request)
    {
      if(Auth::Check())
      {
        $request_data = $request->All();
        $validator = $this->admin_credential_rules($request_data);
        if($validator->fails())
        {

          //return Redirect::back()->with('errors', $validator->getMessageBag());
            return response()->json(['errors'=>$validator->getMessageBag()->all()]);
          //return response()->json(array('errors' => $validator->getMessageBag()->toArray()), 400);
        }
        else
        {  
          $current_password = Auth::User()->password;           
          if(Hash::check($request_data['current'], $current_password))
          {           
            $user_id = Auth::User()->id;                       
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request_data['password']);;
            $obj_user->save(); 
            return 'Password updated';
            //return Redirect::back()->with('success', 'Password updated');
          }
          else
          {       
            $message = 'Please enter correct current password';
            return response()->json(['errors'=> explode(', ', $message)]);    
          }
        }        
      }
      else
      {
        return redirect()->to('/');
      }    
    }
}
