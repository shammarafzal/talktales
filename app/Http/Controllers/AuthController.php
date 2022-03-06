<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use GeneralTrait;
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
                'password' => 'required|min:8'
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
            $token = $user->createToken('app')->accessToken;
            return response([
                'status' => true,
                'message' => 'Success',
                'token' => $token,
                'user' => $user
            ]);
        } catch (\Exception $exception) {
            return response([
                'status' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function user()
    {
        return Auth::user();
    }

    public function register(Request $request)
    {
       
        /** @var User $user */
        $validator = tap(Validator::make($request->all(), [
            'name' => 'required',
            'token' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed:password_confirmation',
            'age' => 'required',
        ]), function () {
            if (request()->hasFile(request()->image)) {
                Validator::make(request()->all(), [
                    'image' => 'required|file|image',
                ]);
            }
        });


        if ($validator->fails()) {
            $message = $validator->errors();
            return collect([
                'status' => false,
                'message' => $message->first()
            ]);
        }
        try {
            if ($validator->passes()) {
                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'age' => $request->input('age'),
                ]);
                $this->storeImage($user);
                $device_token = Token::create([
                    'user_id' => $user->id,
                    'token' => $request->input('token'),
                ]);
                $email = $user->email;
                $token = random_int(1000, 9999);
                DB::table('verify_emails')->insert([
                    'email' => $email,
                    'token' => $token
                ]);

                Mail::send('Mails.verify', ['token' => $token], function (Message $message) use ($email) {
                    $message->to($email);
                    $message->subject('Email Verification Code');
                });

                return response([
                    'status' => true,
                    'message' => 'Check your email',
                    'user' => $user,
                    'device_token' => $device_token,
                ]);
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
            'email' => 'required',
            'token' => 'required',
        ]);
        $token = $request->input('token');
        if (!$VerifyEmails = DB::table('verify_emails')->where('token', $token)->first()) {
            return response([
                'status' => false,
                'message' => 'Invalid token!'
            ], 400);
        }
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('app')->accessToken;
        return response([
            'status' => true,
            'message' => 'Success',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response([
            'status' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function index()
    {
        try {
            $users = User::where('is_admin', 0)->get();
            return response([
                'status' => 'true',
                'users' => $users
            ]);
        } catch (\Exception $exception) {
            return response([
                'status' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, User $user)
    {
        $validator = tap(Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required',
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8|confirmed:password_confirmation',
        ]), function () {
            if (request()->hasFile(request()->image)) {
                Validator::make(request()->all(), [
                    'image' => 'required|file|image',
                ]);
            }
        });


        if ($validator->fails()) {
            $message = $validator->errors();
            return collect([
                'status' => false,
                'message' => $message->first()
            ]);
        }
        try {
            $user->update([
                'name' => $request->input('name'),
                'password' => Hash::make($request->input('password')),
                'age' => $request->input('age'),
            ]);
            $this->storeImage($user);
            return response([
                'status' => true,
                'message' => 'Success',
                'user' => $user
            ]);
        } catch (\Exception $exception) {
            return response([
                'status' => false,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    public function storeImage($user)
    {
        $user->update([
            'image' => $this->imagePath('image', 'user', $user),
        ]);
    }
}
