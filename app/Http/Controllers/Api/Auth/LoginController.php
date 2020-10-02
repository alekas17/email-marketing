<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = apiValidate($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator) {
            return $validator;
        }


        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken(env('APP_KEY'));

            $response = [
                'token' => $token->accessToken,
                'expired_at' => $token->token->expires_at->timestamp,
                'user' => $this->userDetails($user)
            ];

            if (!$user->verified) {


                $this->verifyPhoneNumberResendCode();
            }

            return response()->json($response);
        }

        return response()->json([
            'errors' => [
                'password' => 'Invalid email or password!'
            ]
        ], 422);
    }

    /**
     * Refresh Token
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        $user = Auth::user();

        $response = $this->createToken($user);
        $response['user'] = $this->userDetails();
        $response['message'] = 'Token has been refreshed.';

        return response()->json($response);
    }

    protected function userDetails($user = '')
    {
        $user = auth()->user();
        return [
            "id" => $user->id,
            "gender" => $user->gender,
            "name" => $user->name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "phone" => $user->phone,
            "verified" => $user->verified,
            "user_type" => $user->user_type,
            "referral_link" => route('register') . '?ref=' . $user->id,
            "has_passcode" => ($user->passcode) ? true : false
        ];
    }

    protected function getUserDetails()
    {
        $user_details = ['user_details' => $this->userDetails()];
        return response()->json($user_details);
    }

    public static function verifyPhoneNumberResendCode()
    {
        $user = auth()->user();
        $phone = $user->phone;
        $country_code = "61";

        if (env('COUNTRY_CODE')) {
            $country_code = env('COUNTRY_CODE');
        }

        $authy_api = new \Authy\AuthyApi(env("TWILIO_API_KEY"));
        $authy_api->phoneVerificationStart($phone, $country_code, "sms", "6");
    }
}
