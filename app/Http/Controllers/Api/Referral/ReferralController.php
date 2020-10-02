<?php

namespace App\Http\Controllers\Api\Referral;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ReferralController extends Controller
{
    public function referral()
    {
        $user = auth()->user();

        $refered_user =  User::where('referred_by', $user->id);

        $total_referrals = $refered_user->count();
        $success_referrals = $refered_user->where('verified', 1)->count();

        $bonus_earned = $success_referrals * 5;
        $bonus_earned = !$bonus_earned ? "0.00" : number_format($bonus_earned, 2, '.', ',');

        $referral_link = route('register') . '?ref=' . $user->id;

        return response()->json([
            'success_referrals' => $success_referrals,
            'total_referrals' => $total_referrals,
            'bonus_earned' => $bonus_earned,
            "referral_link" => $referral_link
        ]);
    }
}
