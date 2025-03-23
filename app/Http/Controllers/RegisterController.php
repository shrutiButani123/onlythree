<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function create(){
        $states = State::all();
        return view('register', compact('states'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password',
            'state' => 'required|exists:states,id',
            'city' => 'required|exists:cities,id',
            'hobbies' => 'required|array|min:1',
            'hobbies.*' => 'in:reading,sports,traveling,music',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user  = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'state_id' => $request->state,
            'city_id' => $request->city,
            'hobbies' => json_encode($request->hobbies),
        ]);

        return redirect()->route('login')->with('success', 'User register successfully');
    }

    public function getcities($id){
        $cities = City::where('state_id', $id)->get();
        return response()->json($cities);
    }

}
