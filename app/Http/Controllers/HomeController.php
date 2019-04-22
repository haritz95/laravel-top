<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; 
use App\Sites;
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

        $sites = DB::table('sites')->where('status_id', 1)->orderBy('votes','desc')->simplePaginate(15);

        return view('sites.index', compact('sites'));
    }

    public function admin_credential_rules(array $data)
    {
      $messages = [
        'current-password.required' => 'Please enter current password',
        'password.required' => 'Please enter password',
      ];

      $validator = Validator::make($data, [
        'current-password' => 'required',
        'password' => 'required|same:password',
        'password_confirmation' => 'required|same:password',     
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

          return Redirect::back()->with('errors', $validator->getMessageBag());
          //return response()->json(array('error' => $validator->getMessageBag()->toArray()), 400);
        }
        else
        {  
          $current_password = Auth::User()->password;           
          if(Hash::check($request_data['current-password'], $current_password))
          {           
            $user_id = Auth::User()->id;                       
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request_data['password']);;
            $obj_user->save(); 
            return Redirect::back()->with('message', 'Password updated');
          }
          else
          {           
            return Redirect::back()->with('not_match', 'Please enter correct current password');   
          }
        }        
      }
      else
      {
        return redirect()->to('/');
      }    
    }
}
