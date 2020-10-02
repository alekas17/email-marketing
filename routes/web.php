<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// public routes
Route::any("/phone_verify_proceed", "HomeController@verify_phone");
Route::any("/resend_verification_code", "HomeController@resend_verification_code");
Route::any("/save_new_phone", "HomeController@save_new_phone");
Route::get("/cron_basiq_transactions", "AccountController@cron_basiq_transactions");

Route::any("/terms_of_use", "HomeController@terms_of_use");
Route::any("/security", "HomeController@security");
Route::any("/privacy", "HomeController@privacy");
Route::any("/referral-program", "Page\StaticPageController@referralProgram");

Route::get("/signup", "Auth\RegisterController@cashback_register");
Route::any("/signup/step2", "Auth\RegisterController@cashback_register_step2")->name("cashback_register_step2");
Route::any("/register/step2", "Auth\RegisterController@register_step2")->name("register_step2");

Route::any("/validate_email", "Auth\LoginController@validate_email")->name("validate_email");

Auth::routes();


Route::get('/verification-success', function () {
    return view('auth.verification-success');
});


Route::group(["middleware" => "PhoneVerifyMiddleware:canaccess"], function () {

    Route::get('/signup/phone-verify', "AccountController@cashback_register_phone_verify");
    Route::get('/phone-verify', function () {
        return view('auth.phone-verification');
    });
});



Route::group(
    ['middleware' => ['UserMiddleWare:canaccess']],
    function () {

        Route::get('/', function () {
            $data = [];
            return view("pages.cashbacks.index", $data);
        });

        Route::get("/home", "Page\DashboardController@index");

        Route::get("/{url}", "AccountController@index")
            ->name("account")
            ->where(["url" => "account|account/complete_registration"]);

        Route::any("/accounts_ajax", "AccountController@accounts_ajax");

        Route::resource("cashbacks", "CashbackController");
        Route::any("cashback/ajax", "CashbackController@ajax");

        Route::resource("cashback_merchants", "CashbackMerchantsController");

        Route::any("/yodlee_iframe", "AccountController@yodlee_iframe");

        Route::any("bank-details", [
            'uses' => "Bank\BankController@indexHtml",
            'as' => 'bank.index.html'
        ]);

        //Probably wrap this on a merchant middleware
        Route::get("/merchant/reports", "CashbackMerchantsController@report");
    }
);

Route::group(
    ['middleware' => ['UserMiddleWare:adminaccess']],
    function () {
        Route::get("/administrator", "AdminController@index");
        Route::get("/administrator/user_transactions/{id}", "AdminController@user_transactions");
        Route::get("/administrator/yodlee_transactions/{id}", "AdminController@yodlee_transactions");
        Route::any("/admin_ajax", "AdminController@admin_ajax");
        Route::get("/administrator/cashbacks", "CashbackController@admin");
    }
);

#api
Route::group(['prefix' => 'api/admin/', 'as' => 'api.admin.'], function () {
    #user
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::put('{id}', [
            'uses' => 'Api\User\ProfileController@updateProfile',
            'as' => 'update'
        ]);

        Route::delete('{id}', [
            'uses' => 'Api\User\ProfileController@deleteUser',
            'as' => 'delete'
        ]);

        Route::get('user/account', [
            'uses' => 'Api\User\AccountController@account',
            'as' => 'account'
        ]);

        Route::get('transactions', [
            'uses' => 'Api\User\TransactionController@transactions',
            'as' => 'transactions'
        ]);
    });
    #end user
});
#end api

#Logout
Route::get("/logout", function () {
    return View::make("logout");
});
