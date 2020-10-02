<?php

namespace App\Model\Yodlee;

use Illuminate\Database\Eloquent\Model;
use App\Repository\BaseModelTrait;
use Carbon\Carbon;

class Yodlee extends Model
{
    use BaseModelTrait;

    private static $cob_session;

    private static function get_session()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env("YODLEE_API_URL") . "cobrand/login",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"cobrand\": {\"cobrandLogin\": \"" . env("YODLEE_LOGIN") . "\", \"cobrandPassword\": \"" . env("YODLEE_PASSWORD") . "\", \"locale\": \"" . env("YODLEE_LOCAL") . "\"}}",
            CURLOPT_HTTPHEADER => array(
                "Api-Version: 1.1",
                "Cache-Control: no-cache",
                "Cobrand-Name: " . env("YODLEE_COBRAND_NAME"),
                "Content-Type: application/json",
                "Postman-Token: 0b0936a7-03f8-40c7-addf-50c127cbe57f"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {

            $response = json_decode($response);
            try {
                $session = $response->session->cobSession;
                return $session;
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    private static function api_send($request, $data, $type = "POST", $user_session = "", $session = "")
    {
        if (empty($session)) $session  = self::get_session();

        $curl = curl_init();

        if (!empty($user_session)) {
            $auth_header[] = "cobSession=" . $session;
            $auth_header[] = "userSession=" . $user_session;
            $authorization_pars = "Authorization: {" . implode(",", $auth_header) . "}";
        } else {
            $authorization_pars = "Authorization: cobSession=" . $session;
        }

        self::$cob_session = $session;

        $curl_pars = [
            CURLOPT_URL => env("YODLEE_API_URL") . $request,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Api-Version: 1.1",
                $authorization_pars,
                "Cache-Control: no-cache",
                "Cobrand-Name: " . env("YODLEE_COBRAND_NAME"),
                "Content-Type: application/json",
                "Postman-Token: d0a6a119-281c-4a6c-acb5-f706cf2d5db9"
            ],
        ];

        if ($type == "GET") {
            unset($curl_pars[CURLOPT_POSTFIELDS]);
        }

        curl_setopt_array($curl, $curl_pars);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return json_decode($response);
        }
    }

    private static function generate_random_pwd()
    {
        $caps   = range("A", "Z");
        $small  = range("a", "z");
        $mtrand = mt_rand();


        shuffle($caps);
        shuffle($small);

        $randompassword = str_shuffle($caps[1] . "$%^&" . $caps[2] . $caps[0] . mt_rand() . $small[1] . $small[2] . $small[0]);
        return $randompassword;
    }

    // Get Accounts
    public static function get_accounts_list($user_session, $cob_session)
    {
        try {

            $accounts_list = self::api_send("accounts", [], "GET", $user_session, $cob_session);
            #$transactions  = self::api_send("transactions?fromDate=2018-01-01&toDate=2018-01-30", [] , "GET", $user_session, $cob_session);

            return ["error" => false, "accounts_list" => $accounts_list];
        } catch (\Exception $e) {
            print_r($e);
            return ["error" => true, "message" => "error retreiving accounts list"];
        }
    }

    // Get Account Details
    public static function get_account_details()
    { }

    public static function yodlee_user_session($uid = 0)
    {
        if (empty($uid)) return false;


        $new_password   = self::generate_random_pwd();
        $user_instance  = false;
        $user           = \App\User::find($uid);
        $first_name = $user->name;
        $last_name = $user->last_name;
        $email          = $user->email;
        $yodlee_email   = $user->yodlee_email;
        $password       = $user->yodlee_password;

        $user_session   = "";
        $access_token   = "";
        $error          = false;

        $data          = [
            "user" =>
            [
                "loginName" => $yodlee_email,
                "password"  => $password,
                "locale"    => env("YODLEE_LOCAL")
            ]
        ];
        $user_instance = self::api_send("user/login", $data);



        if (!empty($user_instance->errorMessage)) {
            $response = self::api_send("user/register", [
                "user" =>  [
                    "email"     => $email,
                    "loginName" => $yodlee_email,
                    "password"  => $password,
                    "locale"    => env("YODLEE_LOCAL"),
                    "name" => [
                        "first" => $first_name,
                        "last" => $last_name
                    ],
                ]
            ]);
            $user = \App\User::find($uid);
            if (empty($user->yodlee_password)) {
                $user->yodlee_password = $new_password;

                $user->save();
            }

            $user_instance = $response;
        }

        try {

            $user_session = $user_instance->user->session->userSession;
            #$resp = self::api_send("user/unregister", [] , "DELETE", $user_session);
            #dd($resp);
            try {
                $response = self::api_send("user/accessTokens?appIds=" . env("YODLEE_APP_ID"), [], "GET", $user_session);

                $access_token = $response->user->accessTokens[0]->value;

                return [
                    "error"         => false,
                    "user_session"  => $user_session,
                    "access_token"  => $access_token,
                    "yodlee_user"   => $user_instance,
                    "cob_session"   => self::$cob_session
                ];
            } catch (\Exception $e) {
                return ["error" => true, "message" => "Error getting access token"];
            }
        } catch (\Exception $e) {

            return ["error" => true, "message" => "Error getting user session"];
        }
    }

    public static function get_user_session()
    {

        return self::yodlee_user_session(\Auth::user()->id);
    }

    // Get Transactions
    public static function get_account_transactions($args)
    {
        $user_session   = $args["user_session"];
        $cob_session    = $args["cob_session"];
        $start          = $args["start"];
        $end            = $args["end"];

        $transactions  = self::api_send("transactions?fromDate=" . $end . "&toDate=" . $start, [], "GET", $user_session, $cob_session);

        return $transactions;
    }

    public static function get_webhook_transactions($args)
    {
        $cob_session    = self::get_session();
        $href           = $args["href"];

        $transactions  = self::api_send($href, [], "GET", "", $cob_session);
        return $transactions;
    }

    /**
     * Register User
     * post /user/register
     */
    public static function registerUser($user_id)
    {
        $user = \App\User::find($user_id);
        $first_name = $user->name;
        $last_name = $user->last_name;
        $email = $user->email;
        $yodlee_email = $user->yodlee_email;
        $password = self::generate_random_pwd();

        $new_user = self::api_send("user/register", [
            "user" => [
                "email"     => $email,
                "loginName" => $yodlee_email,
                "password"  => $password,
                "locale"    => env("YODLEE_LOCAL"),
                "name" => [
                    "first" => $first_name,
                    "last" => $last_name
                ],
            ]
        ]);

        if (empty($user->yodlee_password)) {
            $user->yodlee_password = $password;
            $user->save();
        }
        return $new_user;
    }

    /**
     * Delete User
     * delete /user/unregister
     */
    public static function deleteUser($cobSession, $userSession)
    {
        try {
            $response = self::api_send("user/unregister", [], "DELETE", $userSession, $cobSession);
            if (empty($reponse)) {
                return ["error" => false, "msg" => "success"];
            } else {
                return ["error" => true];
            }
        } catch (\Exception $e) {
            print_r($e);
            return ["error" => true, "message" => "error deleting the user"];
        }
    }

    /**
     * Delete Provider Account
     * delete /providerAccounts/{providerAccountId}
     */
    public static function deleteProviderAccount($providerAccountId, $userSession, $cobSession)
    {
        try {
            $response = self::api_send("providers/providerAccounts/" . $providerAccountId, [], "DELETE", $userSession, $cobSession);
            if (empty($reponse)) {
                return ["error" => false, "msg" => "success"];
            } else {
                return ["error" => true];
            }
        } catch (\Exception $e) {
            print_r($e);
            return ["error" => true, "message" => "error deleting provider account"];
        }
    }

    /**
     * Delete Account
     * delete /accounts/{accountId}
     */
    public static function deleteAccount($accountId, $userSession, $cobSession)
    {
        try {
            $response = self::api_send("accounts/" . $accountId, [], "DELETE", $userSession, $cobSession);
            if (empty($reponse)) {
                return ["error" => false, "msg" => "success"];
            } else {
                return ["error" => true];
            }
        } catch (\Exception $e) {
            print_r($e);
            return ["error" => true, "message" => "error deleting account"];
        }
    }

    /**
     * Get Statements
     * get /statements
     */
    public static function getStatements($data, $userSession, $cobSession)
    {
        try {
            $response = self::api_send("statements", $data, "GET", $userSession, $cobSession);
            $statement = $response->statement;

            return ["error" => false, "statement" => $statement];
        } catch (\Exception $e) {
            print_r($e);
            return ["error" => true, "message" => "error getting statements"];
        }
    }

    public function transactions()
    {
        return $this->hasMany('App\Model\Yodlee\Transactions');
    }

    /**
     * Update User
     * @param array $args
     * @param  int $user_id
     * @return mix
     */
    public static function updateUser($args, $user_id)
    {

        try {
            $url = "/user";
            $user  = \App\User::find($user_id);
            $params = [
                "user" => $args
            ];

            $yodlee_user_session = self::yodlee_user_session($user->id);

            $response = self::api_send(
                $url,
                $params,
                "PUT",
                $yodlee_user_session['user_session'],
                $yodlee_user_session['cob_session']
            );

            if (empty($response)) {
                return ["error" => false, "msg" => "success"];
            } else {
                return ["error" => true, 'response' => $response];
            }
        } catch (\Exception $e) {
            return ["error" => true, "message" => $e->getMessage()];
        }
    }

    /**
     * Unregister User
     * @param  int $user_id
     * @return mix
     */
    public static function unregisterUser($user_id)
    {

        try {
            $url = "/user/unregister";
            $user  = \App\User::find($user_id);

            $yodlee_user_session = self::yodlee_user_session($user->id);

            $response = self::api_send(
                $url,
                [],
                "DELETE",
                $yodlee_user_session['user_session'],
                $yodlee_user_session['cob_session']
            );

            if (empty($response)) {
                return ["error" => false, "msg" => "success"];
            } else {
                return ["error" => true, 'response' => $response];
            }
        } catch (\Exception $e) {
            return ["error" => true, "message" => $e->getMessage()];
        }
    }

    /*
    * get all users transactions
    */

    public static function getTransactions($user_id, $query)
    {
        try {
            $url = "/transactions";

            $query_string = buildHttpQuery($query);
            $query_string  = $query_string  ? '?' . $query_string  : "";
            $url .=  $query_string;

            $user  = \App\User::find($user_id);

            $yodlee_user_session = self::yodlee_user_session($user->id);

            $response = self::api_send(
                $url,
                [],
                "GET",
                $yodlee_user_session['user_session'],
                $yodlee_user_session['cob_session']
            );

            $transactions  = [];

            if (isset($response->transaction)) {
                $transactions = $response->transaction;
            }

            /* total transactions */
            $transactions_total = 0;
            $get_transactions_total = self::getTransactionsTotal($user_id, $yodlee_user_session);
            if (isset($get_transactions_total['transactions_total'])) {
                $transactions_total = $get_transactions_total['transactions_total'];
            }

            return [
                'transactions' => $transactions,
                'transactions_total' => $transactions_total,
                'error' => false
            ];
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage(),
                'transactions' => []
            ];
        }
    }

    public static function getTransactionsTotal($user_id, $yodlee_user_session = false)
    {
        try {
            $url = "/transactions/count";

            if (!$yodlee_user_session) {
                $user  = \App\User::find($user_id);
                $yodlee_user_session = self::yodlee_user_session($user->id);
            }


            $response = self::api_send(
                $url,
                [],
                "GET",
                $yodlee_user_session['user_session'],
                $yodlee_user_session['cob_session']
            );

            $transactions_total  = 0;

            if (isset($response->transaction)) {
                $transaction = $response->transaction;

                if (isset($transaction->TOTAL)) {
                    $transactions_total = $transaction->TOTAL->count;
                }
            }

            return [
                'transactions_total' => $transactions_total,
                'error' => false
            ];
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage(),
                'transactions' => []
            ];
        }
    }
}
