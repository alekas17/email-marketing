<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Cashback;
use App\Model\Cashback_merchant;
use App\User;
use Illuminate\Pagination\Paginator;
use App\Model\Yodlee\Yodlee;
use Carbon\Carbon;
use App\Model\Yodlee\Transactions as YodleeTransactions;


class CashbackController extends Controller
{
    //
    private static $id;

    protected function index()
    {

        return view("pages.cashbacks.index");
    }

    protected function admin()
    {
        return view("pages.cashbacks.admin_index");
    }

    private function add_edit($request)
    {
        $merchant_id          = $request->input("merchant_id");
        $user_id              = $request->input("user_id");
        $amount               = $request->input("amount");
        $basiq_transaction_id = $request->input("basiq_transaction_id");
        $status               = $request->input("status");
        $cashback_id          = $request->input("cashback_id");
        $transaction_date     = $request->input("transaction_date");
        $group_id             = $request->input("group_id");

        if (self::$id) {
            $cashback                   = Cashback::find(self::$id);
            $cashback_id                = self::$id;
            $cashback->updated_by           = auth()->user()->id;
        } else {
            $cashback                   = new Cashback;
            $cashback_id                = 0;
            $cashback->created_by           = auth()->user()->id;
        }

        $cashback->merchant_id          = $merchant_id;
        $cashback->user_id              = $user_id;
        $cashback->amount               = $amount;
        $cashback->basiq_transaction_id = $basiq_transaction_id;
        $cashback->status               = $status;
        $cashback->transaction_date     = \Carbon\Carbon::parse($transaction_date);
        $cashback->group_id             = $group_id;

        $success = $cashback->save();

        if ($cashback_id) $add = 0;
        else $add = 1;

        return response()->json(["success" => $success, "add" => $add]);
    }

    protected function store(Request $request)
    {
        return self::add_edit($request);
    }
    protected function update(Request $request, $id)
    {
        self::$id = $id;
        return self::add_edit($request);
    }
    protected function destroy(Request $request, $id)
    {
        $cashback = Cashback::find($id);
        $cashback->delete();
        return response()->json(["success" => 1]);
    }

    protected function ajax(Request $request)
    {
        $cmd = $request->input("cmd");

        switch ($cmd) {
            case "table":
                $cashback_status      = $request->input("cashback_status");
                $dfrom                = $request->input("from");
                $dto                  = $request->input("to");
                $search               = $request->input("search_key");
                $currentPage          = $request->input("page");

                $user = auth()->user();

                $cashback_list = Cashback::select("cashbacks.*", "cashback_merchants.name as merchant_name", "users.email as recipient")
                    ->join("cashback_merchants", "cashback_merchants.id", "=", "cashbacks.merchant_id")
                    ->join("users", "cashbacks.user_id", "=", "users.id");

                if ($user->user_type == 2) {
                    $cashback_list = $cashback_list->where('cashbacks.user_id', $user->id);
                }

                if (!empty($cashback_status)) {
                    $cashback_list = $cashback_list->whereIn("status", $cashback_status);
                }

                if ($search) {

                    $cashback_list = $cashback_list->where(function ($q) use ($search) {
                        $search =  "%" . $search . "%";
                        $q->where("cashback_merchants.name", "like", $search)
                            ->orWhere("users.email", "like", $search)
                            ->orWhere("status", "like", $search)
                            ->orWhere("basiq_transaction_id", "like", $search)
                            ->orWhere("amount", "like", $search);
                    });
                }

                if ($dfrom && $dto) {
                    $dfrom = Carbon::parse($dfrom)->format('y-m-d');
                    $dto = Carbon::parse($dto)->format('y-m-d');

                    $cashback_list = $cashback_list->where(function ($q) use ($dfrom, $dto) {
                        $q->whereDate("cashbacks.transaction_date", ">=", $dfrom)
                            ->whereDate("cashbacks.transaction_date", "<=", $dto);
                    });
                }



                Paginator::currentPageResolver(function () use ($currentPage) {
                    return $currentPage;
                });

                $cashback_list  = $cashback_list->orderby("cashbacks.transaction_date", "desc");
                $cashback_list  = $cashback_list->paginate(10);

                $data["cashback_list"] = $cashback_list;

                if ($user->user_type == 1) {
                    $table = view("pages.cashbacks.admin_list", $data)->render();
                } else {
                    $table = view("pages.cashbacks.list", $data)->render();
                }

                return response()->json([
                    "content" => $table,
                    "count"   => sizeof($data["cashback_list"]),
                ]);
                break; # table

            case "cashback_credits":
                $cashback    = Cashback::where("user_id", \Auth::user()->id)
                    ->get()
                    ->sum("amount");

                $yodlee = Yodlee::get_user_session();
                $accounts = [];
                $accounts_count = [];
                if (!isset($yodlee->error)) {
                    $accounts = Yodlee::get_accounts_list($yodlee["user_session"], $yodlee["cob_session"]);

                    if (isset($accounts['accounts_list'])) {
                        $accounts = $accounts['accounts_list'];
                        if (isset($accounts->account)) {
                            $accounts = $accounts->account;
                            $accounts_count = count($accounts);
                        }
                    }
                }


                return response()->json([
                    "amount"   => number_format($cashback, 2),
                    "accounts" => $accounts_count,
                ]);
                break; //cashback_credits

            case "manage_merchants":
                $data["merchants"] = Cashback_merchant::get();
                $data["users"]     = User::get();
                return response()->json([
                    "content" => view("pages.cashbacks.manage_merchants", $data)->render()
                ]);
                break;

            case "add_cashback_form":
            case "edit_cashback_form":
                $data = [];
                $data["merchants"] = Cashback_merchant::get();
                $data["users"]     = User::get();

                if (!empty($request->input("id"))) {
                    $data["route"]    = "cashbacks.update";
                    $data["method"]   = "PUT";
                    $data["id"]       = $request->input("id");
                    $data["cashback"] = Cashback::find($data["id"]);
                } else {
                    $data["route"]      = "cashbacks.store";
                    $data["method"]     = "POST";
                    $data["id"]         = 0;
                    $data["cashback"]   = false;
                }

                return response()->json([
                    "content" => view("pages.cashbacks.add_cashback", $data)->render()
                ]);
                break; //add_cashback_form
        }
    }
}
