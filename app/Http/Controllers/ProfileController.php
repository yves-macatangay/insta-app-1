<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($id){
        $user = $this->user->findOrFail($id);

        return view('user.profiles.show')->with('user', $user);
    }

    public function edit(){
        //$user = $this->user->findOrFail(Auth::user()->id);
        return view('user.profiles.edit');
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:50|email|unique:users,email,'.Auth::user()->id,
            //creating/adding=  unique:<table name>,<column name>
            //updating =        unique:<table name>,<column name>,<id>
            'avatar' => 'max:1048|mimes:jpeg,jpg,png,gif',
            'introduction' => 'max:100'
        ]);

        $user = $this->user->findOrFail(Auth::user()->id);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;
        if($request->avatar){
            $user->avatar = 'data:image/'.$request->avatar->extension().
                            ';base64,'.base64_encode(file_get_contents($request->avatar));
        }
        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);

    }

    public function followers($id){
        $user = $this->user->findOrFail($id);

        return view('user.profiles.followers')->with('user', $user);
    }

    public function following($id){
        $user = $this->user->findOrFail($id);

        return view('user.profiles.following')->with('user', $user);
    }

    public function updatePassword(Request $request){

        //incorrect (old) password
        $user = $this->user->findOrFail(Auth::user()->id);
        if(!Hash::check($request->old_password, $user->password)){
            //error
            return redirect()->back()->with('old_password_error', 'Incorrect current password.');
        }

        //new password cannot be same as old password
        if($request->old_password == $request->new_password){
            //error
            return redirect()->back()->with('same_password_error', 'New password cannot be the same as current password.');
        }

        //confirm new password
        $request->validate([
            'new_password' => 'required|min:8|string|confirmed'
        ]);

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('change_success', 'Password changed successfuly!');
    }
}
