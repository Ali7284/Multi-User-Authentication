<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class loginController extends Controller
{
    public function index(){
        return view ("admin.login");
    }

   public function authenticate(Request $request)
{
    // Validate the input
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required'
    ]);
   

    // Handle validation failures
    if ($validator->fails()) {
        return redirect()
            ->route('admin.login')
            ->withInput() // Keep old input values
            ->withErrors($validator); // Pass validation errors
    }

    if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
    $user = Auth::guard('admin')->user();

    // Check if the authenticated user has the 'admin' role
    if ($user->role !== 'admin') {
        Auth::guard('admin')->logout();

        // Redirect with an error message
        return redirect()
            ->route('admin.login')
            ->with('error', 'You are not authorized to access this area.');
    }

    // Redirect to admin dashboard if role is valid
    return redirect()->route('admin.dashboard');
}



    // Return error message for incorrect credentials
    return redirect()
        ->route('admin.login')
        ->withInput() // Retain email input, not password
        ->with('error', 'Either email or password is incorrect.');
}

 public function logout(){


        Auth::logout();
        return redirect()->route("admin.login");
    }

}
