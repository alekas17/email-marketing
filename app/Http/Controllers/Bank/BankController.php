<?php

namespace App\Http\Controllers\Bank;

use App\Model\Yodlee\Yodlee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BankController extends Controller
{
    public function indexHtml(Request $request)
    {
        ## remove to remove test
        #Lightrail::award_cashback(601, true);
        #die();

        if (!empty($request->input("JSONcallBackStatus"))) {
            # Dispatch Job If Return from fastlink Callback
            DownloadYodleeTransactionJob::dispatch(\Auth::user()->id)->delay(now()->addSeconds(5));
        }

        $yodlee_user                   = Yodlee::get_user_session();
        $data["user"]                  = auth()->user();
        $data["add_bank"]              = $request->input("add_bank");
        $data["is_cashback"]           = 1;
        $data["yodlee"]                = $yodlee_user;
        $data["complete_registration"] = $request->complete_registration;

        return view("pages.bank.index", $data);
    }
}
