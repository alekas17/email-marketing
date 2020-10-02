<?php

namespace App\Model\Lightrail;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Model\Cashback_merchant;
use App\Model\Cashback;
use App\Model\Yodlee\Transactions as YodleeTransactions;
use App\Repository\BaseModelTrait;
use App\Model\Merchant\Offers\Offer;


class Lightrail extends Model
{
    use BaseModelTrait;

    static function api_send($request, $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.lightrail.com/v2/" . $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Authorization: Bearer " . env("LIGHTRAIL_BEARER_TOKEN")
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    static function create_new_contact($user_id = 0)
    {
        if (empty($user_id)) {
            Log::error("Command: Lightrail create_new_contact -- Can't find user id ");
            return false;
        }


        $uuid          = (string)Str::uuid();
        $value_uuid    = (string)Str::uuid();
        $user          = User::find($user_id);


        ## add contact to lightrail
        $ch = curl_init();
        $contact_data = [
            "id"        => $uuid,
            "firstName" => $user->name,
            "lastName"  => $user->last_name,
            "email"     => $user->email,
            "metadata"  => ["Plastiq Id" => $user_id]
        ];
        self::api_send("contacts", $contact_data);

        ## create lightrail value
        $value_data = [
            "id"         => $value_uuid,
            "programId" => env("LIGHTRAIL_PROGRAM_ID"),
            "balance"   => 0,
            "contactId" => $uuid
        ];

        self::api_send("values?showCode=", $value_data);

        $user->lightrail_uuid       = $uuid;
        $user->lightrail_value_uuid = $value_uuid;
        $user->save();
    }

    static function create_new_merchant_contact($merchant_id = 0)
    {
        if (empty($merchant_id)) {
            Log::error("Command: Lightrail create_new_contact -- Can't find merchant id ");
            return false;
        }


        $uuid          = (string)Str::uuid();
        $value_uuid    = (string)Str::uuid();
        $merchant      = Cashback_merchant::find($merchant_id);


        ## add contact to lightrail
        $ch = curl_init();
        $contact_data = [
            "id"        => $uuid,
            "firstName" => $merchant->name,
            "metadata"  => ["Plastiq Merchant Id" => $merchant_id]
        ];
        self::api_send("contacts", $contact_data);

        ## create lightrail value
        $value_data = [
            "id"         => $value_uuid,
            "programId" => env("LIGHTRAIL_PROGRAM_MERCHANT_ID"),
            "balance"   => 0,
            "contactId" => $uuid
        ];

        self::api_send("values?showCode=", $value_data);

        $merchant->lightrail_uuid       = $uuid;
        $merchant->lightrail_value_uuid = $value_uuid;
        $merchant->save();
    }

    static function award_cashback($transaction_id = 0, $istest = false)
    {
        
        if (!empty($transaction_id)) {
            $transaction = YodleeTransactions::find($transaction_id);

            /* 
            Criteria to award cashback
            1. Get merchant by transaction merchant name
            2. Get merchant Offers
            3. Check if user is eligible
                 a. Match customer type
                 b. Age bracket
                 c. Gender
            */
            
            if (!empty($transaction->merchant_name)) {
                $merchant = Cashback_merchant::where(["name" => $transaction->merchant_name])->first();
                $user     = User::find($transaction->user_id);
               
                # 1. Get merchant by transaction merchant name
                if (!empty($merchant) && !empty($user)) {

                    # 2. get merchant offers
                    $offers = Offer::where("merchant_id", $merchant->id)->get();

                    $transactions    = YodleeTransactions::where("merchant_name", $transaction->merchant_name)
                                        ->where("user_id", $transaction->user_id);

                    # identify customer type
                    if( $transactions->count() <= 1){
                        $customer_type   = "new";
                    }else{  
                        $customer_type   = "existing";
                    }

                    # get user age
                    if(!empty($user->birthday)) $age = \Carbon\Carbon::parse($user->birthday)->age;
                    else $age = 0;

                    # get user gender
                    $gender = "";
                    if(!empty($user->gender)) $gender = $user->gender;
                     
                    # loop through all offers and check if eligible for cashback
                    if(!empty($offers)){
                        foreach($offers as $offer){
                           
                            $customer_type_eligible = false;
                            $age_eligible = false;
                            $gender_eligible = false;
                            
                            #3.a 
                            if(!empty($offer->customer_type)){
                                if( strtolower($offer->customer_type) == strtolower($customer_type) ) $customer_type_eligible = true;
                            }else{
                                $customer_type_eligible = true;
                            }

                            #3.b -> find at least 1 age range eligibility
                            if(!empty($offer->age_ranges ) ){
                                $age_eligible     = false;

                                foreach($offer->age_ranges as $offer_age){
                                    if($offer_age->age_from == 65){
                                        if($age >= $offer_age->age_from ) $age_eligible = true;
                                    }else{
                                        if($age >= $offer_age->age_from && $age <= $offer_age->age_to) $age_eligible = true;
                                    }
                                }

                            }else{
                                $age_eligible = true;
                            }

                            #3.c -> find at least 1 gender eligibility
                            if(!empty($offer->genders ) ){
                                $gender_eligible     = false;

                                foreach($offer->genders as $offer_gender){
                                    if( strtolower($offer_gender->gender) == strtolower($gender) ){
                                        $gender_eligible = true;
                                    }
                                }

                            }else{
                                $gender_eligible = true;
                            }

                            echo "Offer -".$offer->id. "\n";
                            echo "customer_type_eligible -".$customer_type_eligible . "\n";
                            echo "gender_eligible -".$gender_eligible . "\n";
                            echo "age_eligible -".$age_eligible . "\n";

                            if($customer_type_eligible && $gender_eligible && $age_eligible){

                               
                                
                                $amount           = $transaction->amount;
                                $currency         = $transaction->currency;
                                $award_percentage = $offer->amount; # percentage amount of the offer
                                $fee_percentage   = $merchant->fee_percentage;
       
                                $amount_award   = number_format(($amount * $award_percentage) * 100, 0, "", "");
                                $amount_charged = number_format(($amount * $fee_percentage) * 100, 0, "", "");
                                $amount_charged += $amount_award;

                                echo $merchant->name."\n";
                                echo "Customer -" .$customer_type_eligible."\n";
                                echo "Gender -".$gender_eligible."\n";
                                echo "Age -".$age_eligible."\n";
                                echo "Transaction Amount -".$amount."\n";
                                echo "Offer Percentage ".$offer->amount * 100 ."%"."\n";
                                echo "Fee Percentage ".$fee_percentage * 100 ."%"."\n";
                                echo "Amount Award ".number_format($amount_award / 100, 2 )." \n";
                                echo "Amount Charged To Merchant ". number_format($amount_charged / 100 ,2  )."\n";
                                echo "User Lightrail -" . $user->lightrail_value_uuid."\n";
                                echo "Merchant Lightrail -". $merchant->lightrail_value_uuid. " \n";
                                

                               
                                # the Value currency and Transaction currency should match
                                # in order for the transaction credit to go through
                                # in our case Program ID is AUD
                                # and Yodlee sample transactions are in USD. I manually set transaction current to AUD for now
                                $currency         = "AUD";

                                if (!empty($amount)) {
                                    try {
                                        if (!empty($user->lightrail_value_uuid)) {
                                            # award cashback to user
                                            $award_data   = [
                                                "id" => "user-" . $transaction->transaction_id,
                                                "destination" => [
                                                    "rail"    => "lightrail",
                                                    "valueId" => $user->lightrail_value_uuid
                                                ],
                                                "amount"   => (int)$amount_award,
                                                "currency" => $currency,
                                                "metadata" => [
                                                    "merchant"   => $merchant->name,
                                                    "merchantId" => $merchant->id,
                                                    "cashback_percentage" => $award_percentage * 100 . "%",
                                                    "Transaction Amount"  => $amount
                                                ]
                                            ];

                                            $response["user"] = self::api_send("transactions/credit", $award_data);

                                            # charge cashback to merchant
                                          
                                            $charge_data   = [
                                                "id" => "merchant-" . $transaction->transaction_id,
                                                "destination" => [
                                                    "rail"    => "lightrail",
                                                    "valueId" => $merchant->lightrail_value_uuid
                                                ],
                                                "amount"     => (int)$amount_charged,
                                                "currency"   => $currency,
                                                "metadata"   => [
                                                    "User"   => $user->email,
                                                    "UserID" => $user->id,
                                                    "Fee Percentage"      => $fee_percentage * 100 . "%",
                                                    "Transaction Amount"  => $amount
                                                ]
                                            ];

                                            $response["merchant"] = self::api_send("transactions/credit", $charge_data);

                                            if ($istest) dd([$response, $award_data, $charge_data]);
                                            
                                            print_r($response);

                                            $cashback = new Cashback;
                                            $cashback->user_id = $user->id;
                                            $cashback->amount  = $transaction->amount; 
                                            $cashback->merchant_id = $merchant->id;
                                            $cashback->status = "paid";
                                            $cashback->basiq_transaction_id = $transaction_id;
                                            $cashback->save();
                                        }
                                    } catch (\Exception $e) {
                                        $msg = "Error awarding cashback Transaction ID :" . $transaction->id . " Message :" . $e->getMessage();
                                        echo $msg . "<br/>";
                                        Log::error($msg);
                                        #dd($e);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    static function test()
    {
        print_r(\Auth::user()->lightrail_value_uuid);
        $value_data = [
            "id" => \Auth::user()->lightrail_value_uuid,
            "programId" => env("LIGHTRAIL_PROGRAM_ID"),
            "balance"   => 0,
            "contactId" => \Auth::user()->lightrail_uuid
        ];

        $response = self::api_send("values?showCode=", $value_data);
        dd($response);
    }
}
