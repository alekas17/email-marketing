<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Authy\AuthyApi;

class PasscodeController extends Controller
{
    public function validator($request)
    {
        return apiValidate($request, [
            'passcode' => 'required|string|min:4|max:4'
        ]);
    }

    public function check(Request $request)
    {
        $validator  = $this->validator($request->all());
        if ($validator) {
            return $validator;
        }

        $user = auth()->user();

        $passcode = $request->passcode;
        if (!\Hash::check($passcode, $user->passcode)) {
            $user->passcode_throttle += 1;
            $user->save();

            return response()->json([
                'message' => "Invalid passcode.",
                'error' => true,
                'error-code' => 'invalid-passcode',
                'passcode-try' => $user->passcode_throttle
            ]);
        }

        $user->passcode_throttle = 0;
        $user->save();
        return response()->json([
            'message' => "Valid Passcode.",
            "valid" => true
        ]);
    }

    public function update(Request $request)
    {
        $validator  = $this->validator($request->all());
        if ($validator) {
            return $validator;
        }

        $user = auth()->user();

        $passcode = \Hash::make($request->passcode);
        $user->passcode = $passcode;
        $user->save();

        return response()->json([
            'message' => "Passcode has been create.",
            'user' => $user
        ]);
    }

    public function verifyUser(Request $request)
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

        $user->save();

        return response()->json([
            "success" => true,
            "message" => 'Verification code was correct!',
        ]);
    }
}
