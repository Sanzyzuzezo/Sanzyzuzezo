<?php

namespace App\Http\Controllers\Administrator;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/dashboard';

    public function __construct()
    {
      $this->middleware('guest:admin')->except('logout');
    }

    public function index()
    {
      return view('administrator.layouts.login');
    }

    public function login(Request $request)
    {
      // Validate the form data
      $this->validate($request, [
        $this->username()   => 'required|email',
        'password' => 'required|min:6'
      ]);

      // Attempt to log the user in
      if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        return redirect()->route('admin.dashboard');
      } else {
      	session()->flash('error','Credentials not match.');
      }

      $this->incrementLoginAttempts($request);

      // if unsuccessful, then redirect back to the login with the form data
      return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function username()
    {
    	return 'email';
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function isExistEmail(Request $request){
      if($request->ajax()){
          $user = User::select('*');
          if(isset($request->email)){
              $user->where('email', $request->email);
          }
          $data = [ 'valid' => ( $user->count() > 0)  ];
          if(!empty($user)){
              return $data;
          }else{
              return $data;
          }
      }
  }


}
