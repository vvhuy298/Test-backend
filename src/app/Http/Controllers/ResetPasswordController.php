<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Str;
use DB;
use Carbon\Carbon;
use Mail;

class ResetPasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgot(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        $checkExists = DB::table('password_resets')->where('email', $request->email)->count();
        if ($checkExists) {
            return new JsonResponse([
                'status' => 'Error',
                'message' => 'You requested before, confirm your email!',
            ]);
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return new JsonResponse([
            'status' => 'success',
            'message' => 'We have e-mailed your password reset link!',
        ]);
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8',
            'token' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return new JsonResponse([
                'status' => 'Error',
                'message' => 'Invalid token!',
            ]);
        }

        User::where('email', $updatePassword->email)
            ->update(['password' => bcrypt($request->password)]);

        DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Your password has been changed!',
        ]);
    }
}
