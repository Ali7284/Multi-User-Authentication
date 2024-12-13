<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\confirm;

class LoginController extends Controller
{
    public function index(){
        return view("login");
    }

    
public function authenticate(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if ($validator->fails()) {
        // Return with validation errors and old input
        return redirect()
            ->route('account.login')
            ->withInput()
            ->withErrors($validator);
    }

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        return redirect()->route('account.dashboard');
    }

    // Incorrect credentials error
    return redirect()
        ->route('account.login')
        ->with('error', 'Either email or password is incorrect.');
}




    public function register(){
        return view("Register");
    }

    public function processRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=> "required|email|unique:users",
            'password'=> "required|confirmed"
        ]);
        if($validator->passes()){
            $user = new User();
            $user->name =$request->name;
            $user->email =$request->email;
            $user->password =Hash::make($request->password);
            $user->role = "customer";
            $user->save();
            return redirect()->route('account.login')->with('success', "you have register");           

        }else{
            return redirect()->route("account.register")->withInput()->withErrors($validator);
        }
        
    }

    public function logout(){


        Auth::logout();
        return redirect()->route("account.login");
    }
}
