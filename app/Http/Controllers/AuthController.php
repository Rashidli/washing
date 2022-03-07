<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $user->createToken('washingProjectToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(['message', 'Logout succesfully']);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:191',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password))
        {
            return response(['message', 'Invalid'], 401);
        }else
        {
            $token = $user->createToken('washingProjectTokenLogin')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response, 200);
        }
    }















    public function index()
    {
        return view('admin.login');
    }

    public function login_submit(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect()->route('admin_dashboard');
        }
        return redirect()->route('admin_login')->with('danger', 'Wrong password or email');
    }

    public function admin_exit(){
        auth()->logout();
        return redirect()->route('welcome');
    }

}
