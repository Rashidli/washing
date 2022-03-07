<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('type', 1)->get();
        return view('admin.profile' , compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where([['id',$id],['type', 1]])->firstOrFail();


        if(User::where('email',$user->email)->exists()){
            $checkuseremail = User::where('email',$user->email)->first();
            if($checkuseremail->id == $user->id){
                $user->email = request('email');
            }
        }else{
            $user->email = request('email');
        }


        if(request()->filled('password')){

            $user->password = Hash::make(request('password'));

        }

        $user->name = request('name');
        $user->save();


        return redirect()->back();
    }
}
