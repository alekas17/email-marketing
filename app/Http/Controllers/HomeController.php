<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public static function verify_phone(Request $request)
    {
        if (\AUTH::check()) {
            $phone            = \AUTH::user()->phone;
            $country_code     = "61";

            $verfication_code = implode("", $request->input("code"));
            $success          = 1;

            $test_phones      = ["9950849284", "9279445141", "9109214993"];

            if (in_array($phone, $test_phones)) {
                $country_code = "63";
            }

            $authy_api = new \Authy\AuthyApi(env("TWILIO_API_KEY"));

            $res    = $authy_api->phoneVerificationCheck($phone, $country_code, $verfication_code);
            $errors = $res->errors();
            if (!empty($errors->message)) {
                $success = 0;
            } else {
                \AUTH::user()->verified = 1;
                \AUTH::user()->save();
            }

            $message = $res->message();

            return response()->json(["success" => $success, "message" => $message, "errors" => $res->errors(), "cashback_register" => \AUTH::user()->cashback_register]);
        }
    }

    public static function resend_verification_code()
    {
        if (\AUTH::check()) {
            $phone        = \AUTH::user()->phone;
            $country_code = "61";
            if ($phone == "9950849284") {
                $country_code = "63";
            }
            if ($phone == "9109214993") {
                $country_code = "63";
            }

            $authy_api = new \Authy\AuthyApi(env("TWILIO_API_KEY"));
            $res       = $authy_api->phoneVerificationStart($phone, $country_code, "sms", "6");
            return response()->json($res);
        }
    }

    public static function save_new_phone(Request $request)
    {
        if (\AUTH::check()) {
            $phone = $request->input("phone");
            \Auth::user()->phone = $phone;
            \Auth::user()->save();

            $phone            = \AUTH::user()->phone;
            $country_code     = "61";
            $test_phones      = ["9950849284", "9279445141"];
            if (in_array($phone, $test_phones)) {
                $country_code = "63";
            }

            $authy_api = new \Authy\AuthyApi(env("TWILIO_API_KEY"));
            $res       = $authy_api->phoneVerificationStart($phone, $country_code, "sms", "6");

            return response()->json(["message" => $res->message()]);
        }
    }

    public static function terms_of_use()
    { }

    public static function privacy()
    { }

    public static function security()
    { }
}
