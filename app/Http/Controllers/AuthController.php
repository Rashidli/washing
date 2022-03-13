<?php

namespace App\Http\Controllers;

use App\Models\User;
use DOMDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function sendOTP(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        $otpCode = rand(1000, 9999);
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $root = $dom->createElement('request');
        $dom->appendChild($root);

        $result = $dom->createElement('head');
        $root->appendChild($result);

        $result->appendChild($dom->createElement('operation', 'submit'));
        $result->appendChild($dom->createElement('login', 'washing'));
        $result->appendChild($dom->createElement('password', 'w@shin2022!'));
        $result->appendChild($dom->createElement('controlid', '100'));
        $result->appendChild($dom->createElement('title', 'Washing'));
        $result->appendChild($dom->createElement('scheduled', date("Y-m-d H:i:s")));
        $result->appendChild($dom->createElement('isbulk', 'false'));

        $result = $dom->createElement('body');
        $root->appendChild($result);
        $result->appendChild($dom->createElement('message', $otpCode));
        $result->appendChild($dom->createElement('msisdn', $request->phone));

        $xml = $dom->saveXML();

        $curl = curl_init("https://sms.atatexnologiya.az/bulksms/api");
        curl_setopt_array($curl, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $xml,
            CURLOPT_RETURNTRANSFER => true
        ]);
        $result = curl_exec($curl);
        curl_close($curl);

        $ob = simplexml_load_string($result);
        $json = json_encode($ob);
        $response = json_decode($json, true);
        $result = [];
        if (isset($response['head']['responsecode']) && $response['head']['responsecode'] == 000) {
            User::query()->updateOrInsert(
                [
                    'phone' => $request->phone
                ],
                [
                    'otp_code' => $otpCode,
                    'phone' => $request->phone
                ]);
            $result['message'] = 'successfully';
            $result['code'] = 200;
        } else {
            $result['message'] = 'error';
            $result['code'] = 400;
        }

        return response()->json($result);
    }

    public function verifyOTP(Request $request): JsonResponse
    {
        $request->validate([
            'otp' => 'required|min:4|max:4',
            'phone' => 'required'
        ]);
        $response = array();
        $user = User::query()->where(['phone' => $request->phone, 'otp_code' => $request->otp])->first();
        if ($user != null) {
            $response['message'] = 'successfully';
            $response['status'] = 200;
        } else {
            $response['message'] = 'error';
            $response['status'] = 400;
        }

        return response()->json($response);
    }

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

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response(['message', 'Invalid'], 401);
        } else {
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
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('admin_dashboard');
        }
        return redirect()->route('admin_login')->with('danger', 'Wrong password or email');
    }

    public function admin_exit()
    {
        auth()->logout();
        return redirect()->route('welcome');
    }

}
