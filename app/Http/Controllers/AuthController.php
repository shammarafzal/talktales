<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
                'password' => 'required|min:4'
            ]);


            if ($validator->fails()) {
                $message = $validator->errors();
                return response([
                    'status' => false,
                    'message' => $message->first()
                ], 401);
            }
            if (!Auth::attempt($request->only('email', 'password'))) {
                return response([
                    'status' => false,
                    'message' => 'Invalid Password'
                ], 401);
            }
            /** @var User $user */
            $user = Auth::user();
            if ($user->verify == 0) {
                $response = [
                    'status' => false,
                    'message' => 'You are not Verified',
                ];
                return response()->json($response, 413);
            } else {
                $token = $user->createToken('app')->accessToken;
                $response = [
                    'status' => true,
                    'message' => 'Success',
                    'token' => $token,
                    'user' => $user
                ];
                return response()->json($response, 200);
            }
        } catch (\Exception $exception) {
            return response([
                'status' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
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
