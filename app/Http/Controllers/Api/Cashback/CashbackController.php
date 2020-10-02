<?php

namespace App\Http\Controllers\Api\Cashback;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Cashback;
use App\Model\Yodlee\Transactions as YodleeTransactions;

class CashbackController extends Controller
{
    public function index(Request $request)
    {
        $cashback_status      = $request->input("cashback_status");
        $date_from                = $request->input("from");
        $date_to                  = $request->input("to");
        $search               = $request->input("search_key");

        $user = auth()->user();

        $cashbacks = Cashback::select("cashbacks.*", "cashback_merchants.name as merchant_name", "users.email as recipient")
            ->join("cashback_merchants", "cashback_merchants.id", "=", "cashbacks.merchant_id")
            ->join("users", "cashbacks.user_id", "=", "users.id");

        if ($user->user_type == 2) {
            $cashbacks = $cashbacks->where('cashbacks.user_id', $user->id);
        }

        if ($cashback_status) {
            $cashbacks = $cashbacks->whereIn("status", $cashback_status);
        }

        if ($search) {
            $cashbacks = $cashbacks->where(function ($query) use ($search) {
                $query->where("cashback_merchants.name", "like", "%" . $search . "%")
                    ->orWhere("users.email", "like", "%" . $search . "%")
                    ->orWhere("status", "like", "%" . $search . "%")
                    ->orWhere("basiq_transaction_id", "like", "%" . $search . "%")
                    ->orWhere("amount", "like", "%" . $search . "%");
            });
        }

        if ($date_from  && $date_to) {
            $cashbacks = $cashbacks
                ->whereDate("cashbacks.created_at", ">=", $date_from)
                ->whereDate("cashbacks.created_at", "<=", $date_to);
        }

        $cashbacks = $cashbacks->latest()->paginate(10)->withPath('');

        $cashbacks->getCollection()->transform(function ($cashback) {
            $cashback->created_date = $cashback->created_at->format('d/m/Y');
            $cashback->merchant_name_initial = substr($cashback->merchant_name, 0, 1);
            $cashback->amount = $cashback->amount ? number_format($cashback->amount, 2, '.', ',') : "0.00";
            return $cashback;
        });

        return response()->json([
            'message' => 'List of Cashback',
            "cashbacks" => $cashbacks
        ]);
    }

    public function cashbackCredit()
    {
        $user = auth()->user();

        $cashback_total = Cashback::where("user_id", $user->id)
            ->get()
            ->sum("amount");

        $cashback_total =  $cashback_total ? number_format($cashback_total, 2, '.', ',') : "0.00";
        return response()->json([
            "message" => 'Total Cashback Credit',
            "amount"   =>  $cashback_total
        ]);
    }
}
