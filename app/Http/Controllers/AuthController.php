<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'age' => 'required',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'age' => $request->input('age'),
        ]);

        $token = $user->createToken($request->input('name'))->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Account Created Successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => 'User logout successfully',
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'password_confirm' => 'required|same:password',
        ]);

        $user =  User::where('id', auth()->user()->id)->get();
        dd($user);
        DB::table('users')
            ->where('id', $user->id)
            ->update(['password' => $request->password]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->input('email'))->first();
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect',
            ], 401);
        }
        $token = $user->createToken($user->name)->plainTextToken;
        return response()->json([
            'user' => $user,
            'token' => $token,
            'status' => true,
            'message' => 'Login Successfully',
        ], 200);
    }


    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
        ]);
        if ($validator->fails()) {
            $message = $validator->errors();
            return collect([
                'status' => false,
                'message' => $message->first()
            ]);
        }
        $token = random_int(1000, 9999);

        $email = $request->input('email');

        try {
            DB::table('verify_emails')->insert([
                'email' => $request->input('email'),
                'token' => $token
            ]);

            Mail::send('Mails.verify', ['token' => $token], function (Message $message) use ($email) {
                $message->to($email);
                $message->subject('Verify Your Email');
            });

            return response([
                'status' => true,
                'message' => 'Check your email'
            ]);
        } catch (\Exception $exception) {
            return response([
                'status' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function verifyToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
        ]);
        if ($validator->fails()) {
            $message = $validator->errors();
            return collect([
                'status' => false,
                'message' => $message->first()
            ]);
        }
        $token = $request->input('token');
        $verify = DB::table('verify_emails')->where('email', $request->email)->orderBy('id', 'desc')->first();
        if ($verify->token == $token) {
            return response([
                'status' => true,
                'message' => 'Success',
            ], 200);
        } else {
            return response([
                'status' => false,
                'message' => 'Invalid Token!'
            ]);
        }
    }

    public function user()
    {
        $user =  User::where('id', auth()->user()->id)->get();
        return response()->json($user);
    }
}
