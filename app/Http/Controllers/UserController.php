<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function index(){
        return view('login');
    }
    public function authenticate(Request $requuest){
        if(Auth::attempt(['username' => $requuest->username,'password'=> $requuest->password])){
            return redirect()->route('dashboard.index');;
        }else{
            return back()->with('message','incorect username or password');
        }
    }
    public function store(Request $request){
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        
            $user = new User;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = \bcrypt($request->password);
            $user->save();
            return back()->with('messageuser','user inserted successfuly');             
    }
    public function update(Request $request){
        \DB::update('UPDATE users set username = ?, email = ?, password= ? where id = ?',[$request->username, $request->email, \bcrypt($request->password), $request->id]);
            return back()->with('messageupdate','user updated successfuly');
    }
}
