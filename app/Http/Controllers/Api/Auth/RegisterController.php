<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Jobs\CreateLightrailContactandValueJob;
use Authy\AuthyApi;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $phone_validation_unique = config('app.env') == 'production' ? '|unique:users' : '';

        #validator
        $validator = apiValidate($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|numeric' . $phone_validation_unique
        ]);

        if ($validator) {
            return $validator;
        }
        #end validator

        $cashback_register = 0;
        if (!empty($request->cashback_register)) {
            $cashback_register = 1;
        }

        $user =  new User([
            'referred_by' => $request->ref,
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'age_braket' => $request->age_braket,
            'cashback_register' => $cashback_register,
            'verify' => false,
            'password' => Hash::make($request->password)
        ]);
        $user->save();

        $country_code = "61";
        if (env('COUNTRY_CODE')) {
            $country_code = env('COUNTRY_CODE');
        }

        $authy_api = new AuthyApi(env("TWILIO_API_KEY"));
        $authy_api->phoneVerificationStart($request->phone, $country_code, "sms", "6");

        ## dispatch lightrail job
        CreateLightrailContactandValueJob::dispatch($user->id)->delay(now()->addSeconds(5));

        $token = $user->createToken(env('APP_KEY'));

        $response = [
            'message' => 'Registration Successful!',
            'token' => $token->accessToken,
            'expired_at' => $token->token->expires_at->timestamp,
            'user' => $this->userDetails($user)
        ];

        return response()->json($response);
    }

    protected function userDetails($user = '')
    {
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
}
