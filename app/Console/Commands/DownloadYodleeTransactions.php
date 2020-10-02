<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Model\Yodlee\Yodlee;
use App\Model\Yodlee\Transactions as Transactions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Jobs\DownloadYodleeTransactionJob;
use App\Model\Lightrail\Lightrail;

class DownloadYodleeTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:downloadYodleeTransactions';

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
        //
        try{
            
            #Transactions::download_transactions(10); #comment out after testing

            # this is to manually trigger the transaction
            # trigger cashback if its eligible for cashback
            Lightrail::award_cashback(59); #comment out after testing
            
            /* Uncomment after test
            $users = User::where("yodlee_password", "!=", "null")->get();
            foreach($users as $u){
                DownloadYodleeTransactionJob::dispatch($u->id)->delay(now()->addSeconds(5));
                echo $u->id."\n";
            }*/

        }catch(\Exception $e){
            #Log::error("Error : ".$e->getMessage());
            echo $e->getMessage();
        }  
        
    }
}
