<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Cashback;

use \Carbon\Carbon;

class SendPurchasesToBraze extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send-purchases-to-braze';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \Log::info("/SendPurchasesToBraze: start = " . \Carbon\Carbon::now());
        
        $cachbacks = Cashback::where('is_sent', 0)
            ->where('id', 27);
        $merc = $cachbacks->merchant;
        $transaction = new \stdClass();
        $transaction->api_key = "b8cabd90-b9ef-41b2-92d6-c9a9ed30b0d4";
        
        // $obj_1 = new \stdClass();
        // $obj_1->external_id = "144";
        // $obj_1->app_id = "e0ba234c-86dc-41ef-9774-c6dfc46b4284";
        // $obj_1->product_id = "product name";
        // $obj_1->currency = "USD";
        // $obj_1->price = 12.12;
        // $obj_1->quantity = 6;
        // $obj_1->time = "2017-05-12T18:47:12Z";
        
        // $properties = new \stdClass();
        // $properties->merchant_id = 3;
        // $properties->merchant_name = "Russell";
        // $properties->transaction_amount = 2.50;
        // $obj_1->properties = $properties;
        
        $obj_1 = new \stdClass();
        $obj_1->external_id = "144";
        $obj_1->app_id = "e0ba234c-86dc-41ef-9774-c6dfc46b4284";
        $obj_1->product_id = "product name";
        $obj_1->currency = "USD";
        $obj_1->price = 12.12;
        $obj_1->quantity = 6;
        $obj_1->time = "2017-05-12T18:47:12Z";
        
        $properties = new \stdClass();
        $properties->merchant_id = 3;
        $properties->merchant_name = "Russell";
        $properties->transaction_amount = 2.50;
        $obj_1->properties = $properties;

        $transaction->purchases = array($obj_1);
        
        $myJSON = json_encode($transaction);
        \Log::info("/SendPurchasesToBraze: json_encode = " . json_encode($myJSON));

        
        // $response = self::send_to_braze($transaction);
        // \Log::info("/SendPurchasesToBraze: response = " . $response);

        \Log::info("/SendPurchasesToBraze: end = " . \Carbon\Carbon::now());
    }

    static function send_to_braze($transaction)
    {
        $request_url = "users/track";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://sdk.iad-03.braze.com/" . $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);

        if (!empty($transaction)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($transaction));
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $transaction);
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json"
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
