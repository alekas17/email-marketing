<?php

namespace App\Http\Controllers\Api\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Yodlee\Yodlee;

class TransactionController extends Controller
{
    public function transactions(Request $request)
    {
        $user = auth()->user();
        $keyword = $request->keyword;

        $query = [
            "keyword" => $keyword
        ];

        if ($user->user_type == 1) {
            $user = User::find($request->user_id);

            if (!$user) {
                return response()->json([
                    'message' => 'This user was not found ot invalid.'
                ], 404);
            }
        }
        $transactions = [];

        $yodlee_transactions = Yodlee::getTransactions($user->id, $query);

        if ($yodlee_transactions['error']) {
            return response()->json([
                'message' => $yodlee_transactions['message'],
            ], 500);
        }

        $transactions = $yodlee_transactions['transactions'];
        $transactions_total = $yodlee_transactions['transactions_total'];

        if (is_array($transactions)) {
            $transactions = collect($transactions)->map(function ($transaction) {
                $new_transaction = new \stdClass;

                $transaction_date = isset($transaction->transactionDate) ? $transaction->transactionDate : "";

                if ($transaction_date) {
                    $transaction_date = \Carbon\Carbon::parse($transaction_date);
                    $transaction_date = $transaction_date->format('d-m-Y');
                }

                $new_transaction->transaction_date = $transaction_date;
                $new_transaction->transaction_id     = $transaction->id;
                $new_transaction->account_id     = $transaction->accountId;
                $new_transaction->amount     = $transaction->amount->amount;
                $new_transaction->currency     = $transaction->amount->currency;
                $new_transaction->base_type = $transaction->baseType;

                $new_transaction->merchant_name = "";
                if (isset($transaction->merchant)) {
                    if (isset($transaction->merchant->name)) {
                        $new_transaction->merchant_name = $transaction->merchant->name;
                    }
                }

                return $new_transaction;
            });
        } else {
            $transactions = [];
        }

        return response()->json([
            'message' => $user->email . " transactions",
            'transactions' => $transactions,
            'transactions_total' => $transactions_total
        ]);
    }
}
