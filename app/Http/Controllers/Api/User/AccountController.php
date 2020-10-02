<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Yodlee\Yodlee;
use App\Jobs\DownloadYodleeTransactionJob;
use App\User;

class AccountController extends Controller
{
    public function account(Request $request)
    {
        $user = auth()->user();

        $yodlee = [];

        if ($user->user_type == 1) {
            if ($request->user_id) {
                $user = User::find($request->user_id);
            }

            if (!$user) {
                return response()->json([
                    'message' => 'User was not found',
                    'bank_accounts_count' => 0,
                    'bank_accounts' => [],
                ]);
            }
        }

        $yodlee = Yodlee::yodlee_user_session($user->id);

        $accounts = [];
        $bank_accounts_count = 0;

        if (!isset($yodlee->error)) {
            if (!isset($yodlee["user_session"])) {
                return response()->json([
                    'message' => $user->email . " was not connected to Yodlee.",
                    'bank_accounts_count' => $bank_accounts_count,
                    'bank_accounts' => $accounts,
                ], 403);
            }

            $accounts = Yodlee::get_accounts_list($yodlee["user_session"], $yodlee["cob_session"]);

            if (isset($accounts['accounts_list'])) {
                $accounts = $accounts['accounts_list'];

                if (isset($accounts->account)) {
                    $bank_accounts_count = \count($accounts->account);
                }
            }
        }

        return response()->json([
            'message' => 'Account Details',
            'bank_accounts_count' => $bank_accounts_count,
            'bank_accounts' => $accounts,
        ]);
    }

    public function connect()
    {
        $user = auth()->user();
        $yodlee = Yodlee::get_user_session();

        $data = [
            "rsession" => $yodlee["user_session"],
            "token" => $yodlee["access_token"],
            "userID" => $user
        ];
        return view('pages.api.account.yodlee-iframe', $data);
    }

    public function connectAction(Request $request, $action)
    {
        if (!empty($request->JSONcallBackStatus)) {
            DownloadYodleeTransactionJob::dispatch($request->userID)->delay(now()->addSeconds(5));
        }

        if ($action) {
            return view('pages.api.account.yodlee-thank-you');
        }
    }
}
