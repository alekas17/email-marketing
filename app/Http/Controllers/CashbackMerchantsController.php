<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Cashback_merchant;
use App\User;
use App\Jobs\CreateLightrailMerchantContactJob;

class CashbackMerchantsController extends Controller
{
    //
    private static $id;

    private function add_edit($request){
        $name           = $request->input("name");
        $percentage     = $request->input("percentage");
        $merchant_id    = $request->input("merchant_id");
        $fee_percentage = $request->input("fee_percentage");
        $user_id        = $request->input("user_id");
        
        if(self::$id){
            $cashback               = Cashback_Merchant::find(self::$id);
            $cashback_id            = self::$id;
        }else{
            $cashback               = new Cashback_Merchant;
            $cashback_id            = 0;
        }

        $cashback->name             = $name;
        $cashback->merchant_id      = $merchant_id;
        $cashback->cashback_percent = number_format( $percentage / 100, 4 );
        $cashback->fee_percentage   = number_format( $fee_percentage / 100, 4 );
        $cashback->user_id          = $user_id;
       
        $success = $cashback->save();

        if($cashback_id) $add = 0;
        else $add = 1;


        if($add){
            # dispatch lightrail job
            CreateLightrailMerchantContactJob::dispatch($cashback->id)->delay(now()->addSeconds(5));
        }

        return response()->json([ "success" => $success, "add" => $add]);
    }

    protected function store(Request $request){
        return self::add_edit($request);
    }
    protected function update(Request $request,$id){
        self::$id = $id;
        return self::add_edit($request);
    }
    protected function destroy(Request $request, $id){
        $cashback_merchant = Cashback_Merchant::find($id);
        $cashback_merchant->delete();
    }

    protected function report(){
        $data =[];
        return view("pages.reports.index", $data );
    }

}
