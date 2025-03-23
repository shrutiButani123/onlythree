<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create(){
        return view('login');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard')->with('success', 'User login successfully');
        }

        return redirect()->route('login')->with('error', 'Invalid Credentials. Please try again.');
    }

    public function dashboard(){
        return view('dashboard');
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login')->with('success', 'User logout successfully');
    }


}
