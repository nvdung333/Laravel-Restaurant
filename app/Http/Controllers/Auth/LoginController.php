<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Models\Role_User;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {   
        $input = $request->all();
   
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
   
        if(auth()->attempt(array('username' => $input['username'], 'password' => $input['password'])))
        {
            // if (auth()->user()->is_admin == 1) {
            //     return redirect()->route('adminHome');           
            // }else{
            //     return redirect()->route('home');
            // }
            
            $id = auth()->user()->id;
            $roles = Role_User::select('role_id')->where('user_id',$id)->get();
            foreach ($roles as $role)
            {
                $roleid = $role->role_id;
                $roleselect = DB::table('roles')->select('name')->where('id',$roleid)->find($roleid);
                $rolename = $roleselect->name;
                // echo "<pre>";
                // echo "id=".$roleid." name=".$rolename;
                // echo "</pre>";
                if($rolename=="admin" or $rolename=="smod" or $rolename=="mod")
                { return redirect()->route('backendhome'); }
            }
            return redirect()->route('home');
        }
        else
        {
            return redirect()->route('login')
                ->with('error','Username And Password Are Wrong.');
        }   
    }
    
}
