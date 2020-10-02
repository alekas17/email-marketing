<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::any("/yodlee_webhook", "YodleeWebhook@capture");


Route::group(['prefix' => 'v1'], function () {
    #auth route
    Route::post('login', [
        'uses' => 'Api\Auth\LoginController@login',
        'as' => 'api.auth.login'
    ]);

    Route::post('register', [
        'uses' => 'Api\Auth\RegisterController@register',
        'as' => 'api.auth.register'
    ]);

    Route::post('validate/email', [
        'uses' => 'Api\Auth\VerificationController@validateEmail',
        'as' => 'api.validate.email'
    ]);

    Route::post('verify/phone-number', [
        'uses' => 'Api\Auth\VerificationController@verifyPhoneNumber',
        'as' => 'api.verify.phone-number',
        'middleware' => 'auth:api'
    ]);

    Route::post('verify/phone-number/resend-code', [
        'uses' => 'Api\Auth\VerificationController@verifyPhoneNumberResendCode',
        'as' => 'api.verify.phone-number.resend-code',
        'middleware' => 'auth:api'
    ]);

    Route::post('forgot-password', [
        'uses' => 'Api\Auth\ForgotPasswordController@sendResetLinkEmail',
    ]);

    Route::post('change-password', [
        'uses' => 'Api\Auth\ChangePasswordController@changePassword',
        'as' => 'api.auth.change-password',
        'middleware' => 'auth:api'
    ]);

    Route::group(['prefix' => 'passcode', 'middleware' => 'auth:api'], function () {
        Route::post('check', [
            'uses' => 'Api\Auth\PasscodeController@check',
        ]);

        Route::post('update', [
            'uses' => 'Api\Auth\PasscodeController@update',
        ]);

        Route::post('verify-user', [
            'uses' => 'Api\Auth\PasscodeController@verifyUser',
        ]);
    });
    #end auth route

    #cashback
    Route::group(['prefix' => 'cashback', 'as' => 'api.cashback.', 'middleware' => 'auth:api'], function () {
        Route::get('credit', [
            'uses' => 'Api\Cashback\CashbackController@cashbackCredit',
            'as' => 'credit'
        ]);

        Route::resource('', 'Api\Cashback\CashbackController', [
            'only' => ['index'],
        ]);
    });
    #end cashback

    #cashback
    Route::group(['prefix' => 'referral', 'as' => 'api.referral.', 'middleware' => 'auth:api'], function () {
        Route::get('', [
            'uses' => 'Api\Referral\ReferralController@referral',
            'as' => 'get'
        ]);
    });
    #end cashback

    #user
    Route::group(['prefix' => 'user', 'as' => 'api.user.', 'middleware' => 'auth:api'], function () {
        Route::get('profile', [
            'uses' => 'Api\User\ProfileController@profile',
            'as' => 'profile'
        ]);

        Route::put('profile', [
            'uses' => 'Api\User\ProfileController@updateProfile',
            'as' => 'profile'
        ]);

        Route::put('profile/avatar', [
            'uses' => 'Api\User\ProfileController@updateAvatar',
            'as' => 'profile.avatar'
        ]);
        
        Route::get('account', [
            'uses' => 'Api\User\AccountController@account',
            'as' => 'account'
        ]);

        Route::get('account/connect', [
            'uses' => 'Api\User\AccountController@connect',
            'as' => 'account.connect'
        ]);
    });

    Route::get('user/account/connect/{action}', [
        'uses' => 'Api\User\AccountController@connectAction',
        'as' => 'api.user.account.connect.action'
    ]);
    #end user

    #merchant offers
    Route::group(['middleware' => 'auth:api'], function () {
        Route::resources([
            'offers' => 'OfferController',
        ]);
        Route::post("link_merchant_user","CashbackMerchantsController@link_merchant_to_user");
    });
});
