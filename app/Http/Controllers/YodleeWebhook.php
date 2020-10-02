<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Yodlee\Transactions;
use App\Model\Yodlee\Yodlee;
use App\User;
use App\Model\Lightrail\Lightrail;


class YodleeWebhook extends Controller
{

    protected function capture(Request $request)
    {
        if ($request->input("test_mode")) {
            Lightrail::award_cashback($request->input("id")); # remove after testing
            die(); # remove after testing
        }

        $payload = $request->input();
        $event   = $request->input("event");

        $raw_event_transaction = new Transactions;
        $raw_event_transaction->user_id = 0;
        $raw_event_transaction->raw_yodlee_data = json_encode($payload);
        $raw_event_transaction->save();

        //NOTE: Disabled below code to ensure it logs correctly
        $all_input_data = $request->all();
        $all_input_data_transaction = new Transactions;
        $all_input_data_transaction->user_id = 0;
        $all_input_data_transaction->raw_yodlee_data = json_encode($all_input_data);
        $all_input_data_transaction->save();

        $user_data = $event["data"]["userData"];
        $added     = 0;
        foreach ($user_data as $e) {

            if (!empty($e["links"])) {

                $login_name           = $e["user"]["loginName"];
                #$login_name           = "pbpaulbrightjune25@gmail.com"; # remove after testing
                $euser                = User::where("email", "=", $login_name)->get()->first();

                if (!empty($euser)) {

                    foreach ($e["links"] as $link) {
                        $args["href"] = $link["href"];

                        $transactions = Yodlee::get_webhook_transactions($args);

                        # Log transaction
                        $log_transaction = new Transactions;
                        $log_transaction->user_id = $euser->id;
                        $log_transaction->raw_yodlee_data = json_encode($transactions);
                        $log_transaction->save();

                        if (!empty($transactions)) {
                            if (!empty($transactions->userData[0]->transaction)) {

                                foreach ($transactions->userData[0]->transaction as $yodlee_transaction) {

                                    #$yodlee_transaction->status = "POSTED"; # remove after testing

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

                                            $transaction->account_id = $yodlee_transaction->accountId;
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

                                            $transaction->container = $yodlee_transaction->CONTAINER;
                                            $transaction->category_id = $yodlee_transaction->categoryId;
                                            $transaction->category = $yodlee_transaction->category;
                                            $transaction->category_source = $yodlee_transaction->categorySource;
                                            $transaction->high_level_category_id = $yodlee_transaction->highLevelCategoryId;
                                            $transaction->created_date = $yodlee_transaction->createdDate;
                                            $transaction->last_updated = $yodlee_transaction->lastUpdated;

                                            $yodlee_transaction_description = $yodlee_transaction->description;
                                            if ($yodlee_transaction_description) {
                                                $transaction->description_original = $yodlee_transaction_description->original;
                                                $transaction->description_simple = $yodlee_transaction_description->simple;
                                            }

                                            $transaction->type = $yodlee_transaction->type;
                                            $transaction->sub_type = $yodlee_transaction->subType;
                                            $transaction->is_manual = $yodlee_transaction->isManual;
                                            $transaction->source_type = $yodlee_transaction->sourceType;
                                            $transaction->date = $yodlee_transaction->date;
                                            $transaction->post_date = $yodlee_transaction->post_date;
                                            $transaction->status = $yodlee_transaction->status;

                                            if ($yodlee_transaction->merchant) {
                                                $transaction->merchant_source = $yodlee_transaction->merchant->source;

                                                $merchant_category_label = $yodlee_transaction->merchant->categoryLabel;
                                                $merchant_category_label = \is_array($merchant_category_label) ? \implode(":", $merchant_category_label) : $merchant_category_label;
                                                $transaction->merchant_category_label = $merchant_category_label;

                                                $merchant_address = $yodlee_transaction->merchant->address;
                                                if ($merchant_address) {
                                                    $transaction->merchant_address_city = $merchant_address->city;
                                                    $transaction->merchant_address_state = $merchant_address->state;
                                                    $transaction->merchant_address_country = $merchant_address->country;
                                                }
                                            }

                                            $transaction->raw_yodlee_data  = json_encode($yodlee_transaction);
                                            $transaction->save();

                                            #$yodlee_transaction->categoryType = "EXPENSE"; #remove after testing


                                            if (strtoupper($yodlee_transaction->categoryType) == "EXPENSE") {

                                                if (!empty($transaction->user_id)) {
                                                    Lightrail::award_cashback($transaction->id);
                                                }
                                            }

                                            #dd("test done"); #remove after testing

                                            $added++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
