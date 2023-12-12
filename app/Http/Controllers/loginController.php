<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('login', 'register', 'logout', 'loginAction', 'registerUser', 'checkUsername', 'checkEmail');
    }

    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function loginAction(Request $request)
    {
        try {

            // dd($request->toArray());
            $rules = [
                'email' => 'required|email',
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Please fill all mendetory feilds');
            }

            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                if ($user->type == 'user') {
                    return redirect()->intended('/')->with('welcome', 'Mubarakho ' . $user->first_name . '! Tum is platform ka pehla user hoo.');
                    // return redirect()->intended('/')->with('welcome', 'Welcome ' . $user->first_name . '!');
                } else {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Credential does not match');
                }
            }
            return redirect()->route('login')->with('error', 'Credential does not match');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something went wrong ' . $err);
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect()->route('login');
    }

    public function registerUser(Request $request)
    {
        try {
            // dd($request->toArray());
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'username' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Please fill all mendetory feilds');
            }

            $usernameFound = User::where('username', $request->username)->count();
            $emailFound = User::where('email', $request->email)->count();

            if ($usernameFound > 0) {
                return redirect()->back()->with('error', 'Username already taken');
            }

            if ($emailFound > 0) {
                return redirect()->back()->with('error', 'Email already taken');
            }

            $user = new User();
            $user->first_name = ucfirst($request->first_name) ?? '';
            $user->last_name = ucfirst($request->last_name) ?? '';
            $user->name =  ucfirst($request->first_name) . ' ' . ucfirst($request->last_name);
            $user->username = strtolower($request->username) ?? '';
            $user->email = strtolower($request->email) ?? '';
            $user->password = Hash::make($request->password);
            $user->plain_pass = $request->password ?? '';
            $user->profile_pic = '';
            $user->status = 'active';
            $user->type = 'user';
            $user->email_verified_at = Carbon::now();
            $user->save();

            $userInfo = new UserInformation();
            $userInfo->user_id = $user->id;
            $userInfo->status = 'online';
            $userInfo->save();

            return redirect()->route('login')->with('success',  $user->first_name . ', acc create ho gya ab fatak se login karo');
            // return redirect()->route('login')->with('success',  $user->first_name . ', your account is successfully created please login to continue');
        } catch (\Exception $err) {
            return redirect()->back()->with('error', 'Something went wrong ' . $err);
        }
    }

    public function checkUsername(Request $request)
    {
        try {
            $rules = [
                'username' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => '(Please Provide valid username)']);
            }

            $usernameFound = User::where('username', $request->username)->count();

            if ($usernameFound > 0) {
                return response()->json(['status' => false, 'message' => '(username already taken)']);
            } else {
                return response()->json(['status' => true, 'message' => 'Username Accepted']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => '(Please try again)']);
        }
    }
    public function checkEmail(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => '(Please Provide valid email)']);
            }

            $useremailFound = User::where('email', $request->email)->count();

            if ($useremailFound > 0) {
                return response()->json(['status' => false, 'message' => '(email already taken)']);
            } else {
                return response()->json(['status' => true, 'message' => 'email Accepted']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => '(Please try again)']);
        }
    }
}
