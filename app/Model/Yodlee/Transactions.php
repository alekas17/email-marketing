<?php

namespace App\Model\Yodlee;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Model\Lightrail\Lightrail;
use App\Repository\BaseModelTrait;

class Transactions extends Model
{
    use BaseModelTrait;

    protected $table = "yodlee_transactions";
    protected $fillable = ["*"];

    static function download_transactions($uid = 0)
    {
      
        $users = \App\User::where("yodlee_password", "!=", "null");
        if (!empty($uid)) $users = $users->where("id", $uid);
        $users = $users->select(["id", "yodlee_fetch_daily"])->get();

        if ($users->count() > 0) {
        
            foreach ($users as $euser) {
                $added = 0;

                try {
                    $start = Carbon::now()->format("Y-m-d");
                    if ($euser->yodlee_fetch_daily === 0) {
                        $end   = Carbon::now()->subDays("365")->format("Y-m-d");
                    } else {
                        $end   = Carbon::parse($start)->subDays("3")->format("Y-m-d");
                        $start = Carbon::parse($start)->addDays("1")->format("Y-m-d");
                    }
                   
                    $user_session = Yodlee::yodlee_user_session($euser->id);
                    $pars["user_session"] = $user_session["user_session"];
                    $pars["cob_session"]  = $user_session["cob_session"];

                    $pars["start"]        = $start;
                    $pars["end"]          = $end;

                    
                    # capture only "POSTED" transactions
                    $transactions = Yodlee::get_account_transactions($pars);
                    
                    if (!empty($transactions)) {

                        if (!empty($transactions->transaction)) {

                            foreach ($transactions->transaction as $yodlee_transaction) {

                                if (strtoupper($yodlee_transaction->status) == "POSTED") {



                                    $exists = Transactions::where("transaction_id", "=", $yodlee_transaction->id)->get();

                                    if ($exists->count() === 0) {


                                        $transaction = new \App\Model\Yodlee\Transactions;
                                        $transaction->user_id          = $euser->id;
                                        $transaction->transaction_id   = $yodlee_transaction->id;

                                        if (!empty($yodlee_transaction->amount)) {
                                            $transaction->amount       = $yodlee_transaction->amount->amount;
                                            $transaction->currency     = $yodlee_transaction->amount->currency;
                                        }
                                        $transaction->base_type        = $yodlee_transaction->baseType;
                                        $transaction->category_type    = $yodlee_transaction->categoryType;

                                        if (!empty($yodlee_transaction->transactionDate)) {
                                            $transaction->transaction_date = $yodlee_transaction->transactionDate;
                                        }

                                        $transaction->account_id       = $yodlee_transaction->accountId;
                                        if (!empty($yodlee_transaction->merchant)) {

                                            if (!empty($yodlee_transaction->merchant->name)) {
                                                $transaction->merchant_name = $yodlee_transaction->merchant->name;
                                            }

                                            if (!empty($yodlee_transaction->merchant->id)) {
                                                $transaction->merchant_id = $yodlee_transaction->merchant->id;
                                            }
                                        }

                                        if (empty($transaction->merchant_name)) {
                                            if (!empty($yodlee_transaction->description)) {
                                                if (!empty($yodlee_transaction->description->simple)) {
                                                    $transaction->merchant_name = $yodlee_transaction->description->simple;
                                                }
                                            }
                                        }

                                        $transaction->raw_yodlee_data  = json_encode($yodlee_transaction);

                                        $transaction->save();

                                        /* lightrail award cashback transaction to user  and charge merchant */
                                        if (strtoupper($yodlee_transaction->categoryType) == "EXPENSE") {

                                            if (!empty($transaction->user_id)) {
                                                Lightrail::award_cashback($transaction->id);
                                            }
                                        }

                                        $added++;
                                    }
                                }
                            }
                        }
                    }

                    #echo $euser->id. " - ".$added."\n";


                    if (!empty($added)) {
                        $user = \App\User::find($euser->id);
                        $user->yodlee_fetch_daily = 1;
                        $user->save();
                    }
                } catch (\Exception $e) {
                    #dd($e);
                    echo $e->getMessage();
                    # Log::error("Command:DownloadYodleeTransaction -- UserID : " . $euser->id . " --" . $e->getMessage());
                    #log error HERE
                }
            }
        }

        #return true;
    }
}
