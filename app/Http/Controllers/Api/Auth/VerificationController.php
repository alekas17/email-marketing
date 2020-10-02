<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Authy\AuthyApi;

class VerificationController extends Controller
{
    public function validateEmail(Request $request)
    {
        $validator = apiValidate($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator) {
            return $validator;
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'message' => 'Email already exist.',
                'name' => $user->name,
                'email_exist' => true
            ]);
        }

        return response()->json([
            'message' => 'Email not exist.',
            'email_exist' => false
        ]);
    }

    public function verifyPhoneNumber(Request $request)
    {
        $validator = apiValidate($request->all(), [
            'code' => 'required',
        ]);

        if ($validator) {
            return $validator;
        }

        $user = auth()->user();

        $phone = $user->phone;
        $country_code = "61";

        $verfication_code = $request->code;

        if (env('COUNTRY_CODE')) {
            $country_code = env('COUNTRY_CODE');
        }

        $authy_api = new AuthyApi(env("TWILIO_API_KEY"));

        $phoneVerificationCheck    = $authy_api->phoneVerificationCheck($phone, $country_code, $verfication_code);
        $errors = $phoneVerificationCheck->errors();

        if (isset($errors->message)) {
            return response()->json([
                'errors' => ['code' => $errors->message]
            ], 422);
        }

        $user->verified = true;
        $user->save();

        return response()->json([
            "success" => true,
            "message" => 'Your account was verified!',
            "cashback_register" => $user->cashback_register
        ]);
    }

    public static function verifyPhoneNumberResendCode()
    {
        $user = auth()->user();
        $phone = $user->phone;
        $country_code = "61";

        if (env('COUNTRY_CODE')) {
            $country_code = env('COUNTRY_CODE');
        }

        $authy_api = new AuthyApi(env("TWILIO_API_KEY"));
        $phoneVerificationStart = $authy_api->phoneVerificationStart($phone, $country_code, "sms", "6");
        $errors = $phoneVerificationStart->errors();

        if (isset($errors->message)) {
            return response()->json([
                'message' => $errors->message,
                'success' => false,
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => 'New code was sent!',
        ]);
    }
}
