<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Model\Yodlee\Yodlee;
use App\Model\Yodlee\Transactions as YodleeTransactions;
use Illuminate\Support\Facades\Hash;
use App\Jobs\DownloadYodleeTransactionJob;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    //

    public static function index(Request $request, $complete_registration)
    {

        ## remove to remove test
        #Lightrail::award_cashback(601, true);
        #die();

        if (!empty($request->input("JSONcallBackStatus"))) {
            # Dispatch Job If Return from fastlink Callback
            //DownloadYodleeTransactionJob::dispatch(\Auth::user()->id)->delay(now()->addSeconds(5));
            Transactions::download_transactions(\Auth::user()->id);
        }

        $is_complete_registration = 0;
        if ($complete_registration == "account/complete_registration") $is_complete_registration = 1;

        $yodlee_user                   = Yodlee::get_user_session();
        $data["user"]                  = \AUTH::user();
        $data["add_bank"]              = $request->input("add_bank");
        $data["is_cashback"]           = 1;
        $data["yodlee"]                = $yodlee_user;
        $data["complete_registration"] = $is_complete_registration;

        return view("pages.account", $data);
    }


    public static function accounts_ajax(Request $request)
    {
        /* request validitaion */
        $rules = [
            'postal' => 'numeric',
            'birthday' => $request->birthday ? 'date' : ''
        ];

        $validator = Validator::make(
            $request->all(),
            $rules
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $error = $errors ? $errors[0] : '';

            return response()->json([
                'errors' => $validator->errors(),
                'success' => 0,
                'message' => $error
            ]);
        }
        /* end request validitaion */

        $cmd = $request->input("cmd");
        switch ($cmd) {
            case "yodlee_accounts_list":

                $user_session = $request->input("usersession");
                $cob_session  = $request->input("cobsession");

                $data["accounts"] = Yodlee::get_accounts_list($user_session, $cob_session);
                return response()->json([
                    "content" => view("pages.accounts.yodlee_accounts", $data)->render()
                ]);
                break; //yodlee_accounts_list

            case "save_account_updates":

                $error      = false;
                $response   = [];

                $first_name     = $request->input("first_name");
                $last_name      = $request->input("last_name");
                $phone          = $request->input("phone");
                $is_change_pwd  = $request->input("is_change_pwd");
                $oldpw          = $request->input("oldpw");
                $newpwd         = $request->input("newpwd");
                $confirm_pwd    = $request->input("confirm-pwd");
                $birthday       = $request->input("birthday");
                $postal         = $request->input("postal");

                $user             = User::find(\AUTH::user()->id);
                $user->name       = $first_name;
                $user->last_name  = $last_name;
                $user->phone      = $phone;
                $user->birthday   = \Carbon\Carbon::parse($birthday);
                $user->postal     = $postal;

                if ($is_change_pwd) {
                    if ($newpwd != $confirm_pwd) {
                        $error               = 1;
                        $response["success"] = 0;
                        $response["message"] = "Passwords do not match";
                    }
                    if (!Hash::check($oldpw, $user->password)) {
                        $error               = 1;
                        $response["success"] = 0;
                        $response["message"] = "Wrong password";
                    }

                    if (!$error) {
                        $user->password = Hash::make($newpwd);
                    }
                }

                if (!$error) {
                    /* update yodlee account */
                    $yodlee_update_user = Yodlee::updateUser(
                        [
                            "email" => $user->email,
                            "name" => [
                                "first" => $user->name,
                                "last" => $user->last_name
                            ]
                        ],
                        $user->id
                    );
                    /* end update yodlee account */

                    $user->save();
                    $response["success"] = 1;
                    $response["message"] = "Updates saved";
                }

                return response()->json($response);

                break;
        }
    }


    protected function cashback_register_phone_verify()
    {

        $yodlee_user    = Yodlee::get_user_session();
        $data["user"]   = \AUTH::user();
        $data["yodlee"] = $yodlee_user;
        return view("auth.phone-verification-cashback", $data);
    }

    protected function yodlee_iframe(Request $request)
    {

        $data["app"]      = $request->input("app");
        $data["rsession"] = $request->input("rsession");
        $data["token"]    = $request->input("token");

        $data["JSONcallBackStatus"] = $request->input("JSONcallBackStatus");

        if (!empty($request->input("JSONcallBackStatus"))) {
            # Dispatch Job If Return from fastlink Callback
            DownloadYodleeTransactionJob::dispatch(\Auth::user()->id)->delay(now()->addSeconds(5));
        }

        # if user clicks fastlink close
        if ($request->close) {
            $data["JSONcallBackStatus"] = 1;
        }
        /*
        $http_referrer   = parse_url($_SERVER["HTTP_REFERER"]);
        $yodlee_node_url = parse_url(env("YODLEE_NODE_URL"));
        if ($yodlee_node_url["host"] == $http_referrer["host"]) {
            $data["JSONcallBackStatus"] = 1;
        }
        */

        return view("pages.accounts.yodlee_fastlink_form", $data);
    }
}
