<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Cashback_merchant as Merchant;
use App\Model\Merchant\Offers\Offer;
use App\Model\Merchant\Offers\AgeRange as OfferAgeRange;
use App\Model\Merchant\Offers\Gender as OfferGender;

class OfferController extends Controller
{
    //
    private $id;

    protected function index(Request $request){
        $error       = false;
        $merchant_id = $request->input("merchant_id");
        $merchant    = Merchant::find($merchant_id);
        
        $user_id = 0;
        if(!empty($user->user)){
            $user_id = $merchant->user->id;
        }
        
        if(!empty($merchant->offers)){
            $merchant->offers = $merchant->offers->map( function($offer){
            
                if(!empty($offer->genders)){
                    $offer->genders = $offer->genders;
                }else{
                    $offer->genders = [];
                }

                if(!empty($offer->age_ranges)){
                    $offer->age_ranges = $offer->age_ranges;
                }else{
                    $offer->age_ranges = [];
                }

                $offer->amount = number_format($offer->amount * 100, 2);
                return $offer;
            });
        }


        return response()->json([
            "user_id" => $user_id,
            "merchant_id" => $merchant_id,
            "offers" => $merchant->offers
        ]);
    }

    protected function add_update($request){
        $amount = $request->input("amount");
        $customer_type = $request->input("customer_type");
        $gender = $request->input("gender");
        $age_range = $request->input("age_range");
        $merchant_id = $request->input("merchant_id");
        $gender = $request->input("gender");

        if(!empty($this->id)){
            $offer = Offer::find($this->id);
            
        }else{
            $offer = new Offer;
        }

        $offer->amount = number_format( $amount / 100, 4 );
        $offer->customer_type = $customer_type;
        $offer->merchant_id = $merchant_id;

        $offer->save();

        if(!empty($this->id)){
            $delete_age_range = OfferAgeRange::where("offer_id", $offer->id);
            $delete_age_range->delete();
        }


        if(!empty($age_range)){
            /*$post->comments()->saveMany([
                new App\Comment(['message' => 'A new comment.']),
                new App\Comment(['message' => 'Another comment.']),
            ]);*/
            if(!is_array($age_range)){
                $arr_age_range[] = $age_range;
            }else{
                $arr_age_range = $age_range;
            }

            
            foreach($arr_age_range as $eage_range){
                $ar = new OfferAgeRange;
                $arr = explode("-",$eage_range);
                $arr[0] = str_replace("+","", $arr[0]);

                $ar->offer_id = $offer->id;
                $ar->age_from = $arr[0];
                if(!empty($arr[1]) ) $ar->age_to = $arr[1];
                if($arr[0]==65) $ar->age_to = 0;
                $ar->save();
            }
        }

        if(!empty($this->id)){
            $delete_gender = OfferGender::where("offer_id", $offer->id);
            $delete_gender->delete();
        }

        if(!empty($gender)){
            
            if(!is_array($gender)){
                $arr_gender[] = $gender;
            }else{
                $arr_gender = $gender;
            }

           
            foreach($arr_gender as $e_gender){
                $gr = new OfferGender;
                $gr->offer_id = $offer->id;
                $gr->gender = $e_gender;
                $gr->save();
            }
        }

        return response()->json(["success"=>true]);
    }

    protected function update(Request $request, $id){
        $this->id = $id;
        return self::add_update($request);
    }

    protected function store(Request $request){
        return self::add_update($request);
    }

    protected function destroy($id){
        $offer = Offer::find($id);
        $offer->delete();
        return response()->json(["success" => true]);
    }
}
