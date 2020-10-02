<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use App\Jobs\CreateLightrailContactandValueJob;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    protected $validated_fields = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, $this->validated_fields);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $cashback_register = 0;
        if (!empty($data["cashback_register"])) $cashback_register = 1;


        // Send Verification to phone
        if (!empty($data["phone"])) {
            $phone            = $data["phone"];
            $country_code     = "61";
            $test_phones      = ["9950849284", "9279445141", "9109214993"];
            if (in_array($phone, $test_phones)) {
                $country_code = "63";
            }

            $authy_api = new \Authy\AuthyApi(env("TWILIO_API_KEY"));
            $res = $authy_api->phoneVerificationStart($phone, $country_code, "sms", "6");
        }

        $data['cashback_register'] =  $cashback_register;
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        ## dispatch lightrail job
        CreateLightrailContactandValueJob::dispatch($user->id)->delay(now()->addSeconds(5));

        $user->yodlee_email = $user->id . "@yodlee.plastiq.it";
        $user->save();

        return $user;
    }

    protected function register_step2(Request $request)
    {
        $data["referred_by"]  = $request->input("referred_by");
        $data["name"]  = $request->input("name");
        $data["lname"] = $request->input("last_name");
        $data["email"] = $request->input("email");

        $validator =  Validator::make($data, [
            'email' => $this->validated_fields["email"],
        ]);

        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

        return view("auth.register_step2", $data);
    }

    protected function cashback_register(Request $request)
    {
        return view("auth.cashback_register");
    }

    protected function cashback_register_step2(Request $request)
    {

        $data["name"]  = $request->input("name");
        $data["lname"] = $request->input("last_name");
        $data["email"] = strtolower($request->input("email"));

        $validator =  Validator::make($data, [
            'email' => $this->validated_fields["email"],
        ]);

        if ($validator->fails()) {
            return redirect('signup')
                ->withErrors($validator)
                ->withInput();
        }

        return view("auth.cashback_register_step2", $data);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        $referred_by = $request->ref;

        return view('auth.register', [
            'referred_by' => $referred_by
        ]);
    }
}
