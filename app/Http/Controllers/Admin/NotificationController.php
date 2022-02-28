<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('notification.index');
    }

    public function fetchNotifications(){
        $notifications = Notification::all();
        return response()->json([
            'status' => true,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'body' => 'required',
        ]);
        if (!$validator->passes()){
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
        try {
            $response = '';

            $SERVER_API_KEY = 'AAAALiDuRoo:APA91bG9vg88duBhYDWTgfRSlkFBwDbUVipBk61XolqZMZePc-6bcB0jZ9GZXufX0Dq0H0nIZW0m27ihhMXgzqEPfc2juNFuW-PNbaIkKXjqHDlut3JvTSsNYLeOaqcsI6ZRHdWHsSK4';
            if ($request->device_id){
                $tokens = Token::whereIn('nurse_id', $request->device_id)->get();
            }
            else {
                $tokens = Token::all();
            }
            foreach ($tokens as $token){
                $token_1 = $token->token;

                $data = [

                    "registration_ids" => [
                        $token_1
                    ],

                    "notification" => [

                        "title" => $request->input('title'),

                        "body" => $request->input('body'),

                        "sound" => "default" // required for sound on ios

                    ],

                ];

                $dataString = json_encode($data);

                $headers = [

                    'Authorization: key=' . $SERVER_API_KEY,

                    'Content-Type: application/json',

                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

                curl_setopt($ch, CURLOPT_POST, true);

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

                $response = curl_exec($ch);
            }
            if ($response){
                Notification::create([
                    'title' => $request->input('title'),
                    'body' => $request->input('body'),
                ]);
                $message = 'Notification send successfully';
            }
            else{
                $message = 'Notification not send';
            }
            return response()->json(['status' => 1, 'message' => $message,]);
        }catch (\Exception $exception){
            return response()->json($exception->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
