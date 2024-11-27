<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function dashboardPage(){
        return view('dashboard.index');
       
    }   

    public function showLoginForm()
    {
        // Check if the user is already authenticated
    if (Auth::check()) {
        // If the user is authenticated, redirect them to the dashboard
        return redirect()->route('dashboard');
    }
        return view('login');
    }

    public function login(Request $request){

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //return $request;
          //echo bcrypt('123456');
         //exit; 
     
        if(Auth::attempt($credentials)){
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('login')->withErrors([
                'email' => 'Invalid credentials provided.',
            ]);
        }
        
    }
    public function logout(){
        Auth::logout();
        return view('login');
    }

}
