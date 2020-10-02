<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Model\Yodlee\Transactions;

class AdminController extends Controller
{
    //
    public static function index()
    {
        return view("pages.admin.index");
    }

    public static function user_transactions(Request $request, $user_id)
    {
        $data["user"] = User::find($user_id);
        return view("pages.admin.user_transactions", $data);
    }
    public static function yodlee_transactions(Request $request, $user_id)
    {
        $data["user"] = User::find($user_id);
        return view("pages.admin.yodlee_transactions", $data);
    }

    public static function admin_ajax(Request $request)
    {
        $cmd = $request->input("cmd");
        switch ($cmd) {
            case "users_list":
                $search               = $request->input("search_key");
                $currentPage          = $request->input("page");

                $users_list           = User::where("name", "like", "%" . $search . "%")
                    ->orWhere("last_name", "like", "%" . $search . "%")
                    ->orWhere("phone", "like", "%" . $search . "%")
                    ->orWhere("email", "like", "%" . $search . "%");

                Paginator::currentPageResolver(function () use ($currentPage) {
                    return $currentPage;
                });

                $users_list  = $users_list->paginate(10);

                $data["users_list"] = $users_list;

                return response()->json([
                    "content" => view("pages.admin.users_list", $data)->render(),
                    "count"   => sizeof($data["users_list"])
                ]);

                break;

            case "yodlee_transactions_list":
                $user_id           = $request->input("user_id");
                $currentPage       = $request->input("page");
                $search            = $request->input("search_key");

                $transactions_list = Transactions::where("user_id", $user_id);

                if (!empty($search)) {
                    $transactions_list = $transactions_list->where(function ($q) use ($search) {
                        $q->where("amount", "like", "%" . $search . "%")
                            ->orWhere("account_id", "like", "%" . $search . "%")
                            ->orWhere("merchant_name", "like", "%" . $search . "%")
                            ->orWhere("currency", "like", "%" . $search . "%")
                            ->orWhere("raw_yodlee_data", "like", "%" . $search . "%");
                    });
                }

                #$transactions_list = $transactions_list->join("basiq_accounts", "account", "=", "account_id");

                Paginator::currentPageResolver(function () use ($currentPage) {
                    return $currentPage;
                });

                $transactions_list     = $transactions_list->paginate(10);
                $data["transactions"]  = $transactions_list;

                return response()->json([
                    "content" => view("pages.admin.yodlee_transactions_table", $data)->render(),
                    "count"   => sizeof($data["transactions"])
                ]);
                break;

            case "update_password_form":

                $data["user_id"] = $request->input("userid");
                $data["user"]    = User::find($data["user_id"]);
                return response()->json([
                    "content" => view("pages.admin.update_password_form", $data)->render(),
                    "email"   => $data["user"]->email
                ]);
                break;

            case "update_password":
                $password = $request->input("password");
                $user_id  = $request->input("user_id");
                $user     = User::find($user_id);
                $user->password = Hash::make($password);
                $user->save();
                break;
        }
    }
}
