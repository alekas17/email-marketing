<!DOCTYPE html>


<html lang="en">

<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <style type="text/css">
    input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
    </style>

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
    WebFont.load({
        google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
        active: function() {
            sessionStorage.fonts = true;
        }
        });
    </script>

    <!--end::Web font -->

    <!--end:: Global Optional Vendors -->

    <!--begin::Global Theme Styles -->
    <link rel="stylesheet" href="{{url('metronic/theme/default/dist/default/assets/vendors/base/vendors.bundle.css')}}">
    <link href="{{url('metronic/theme/default/dist/default/assets')}}/demo/default/base/style.bundle.css" rel="stylesheet"
        type="text/css" />

    <!--RTL version:<link href="{{url('metronic/theme/default/dist/default/assets')}}/demo/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link rel="stylesheet" href="{{url(mix('css/login.css'))}}">
    <style type="text/css">
    .txt-phone-verify{
        background:#fff !important;
    }
    .modal {
        -webkit-overflow-scrolling: touch;
    }
    </style>
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body id="login" class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin"
            id="m_login" style="background:url({{url('/images/login-bg-full.png')}}) no-repeat top center/cover">
            <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside" style="margin:auto">
                <div class="m-stack m-stack--hor m-stack--desktop">
                    <div class="m-stack__item m-stack__item--fluid">
                        <div class="m-login__wrapper">
                            <div class="m-login__logo">
                                <a href="#">
                                    <img src="{{ url('images/logo-new-white.png') }}" alt="">
                                </a>
                            </div>
                            <div class="m-login__signup phone-verification" style="display:block;">
                                <div class="m-login__head">
                                    <h3 class="m-login__title" style="color:#fff">Phone Number Verification</h3>
                                    <div class="m-login__desc" style="color:#fff">A 6-digit code has been sent to <br>
                                        <div class="row row-input-new-phone " style="display:none; margin-top:10px;">
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="new_phone" value="@if(!empty(\AUTH::user()->phone)) {{\AUTH::user()->phone}} @endif"/>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-primary btn-with-act" data-act="save_new_verify_phone">Save</button>
                                            </div>
                                        </div>
                                        <strong class="verify-phone">@if(!empty(\AUTH::user()->phone)) {{\AUTH::user()->phone}} @endif</strong>
                                        <span class="verify-change-button">
                                            <a href="javascript:void(0);" class="btn-with-act" data-act="change_verify_phone_number" style="color:#fff">Change</a>
                                        </span>
                                    </div>
                                </div>

                                <input type="hidden" autocomplete="one-time-code" class="hidden-otp"/>

                                <form class="m-login__form m-form form-verify-phone" method="POST" action="">
                                    @csrf

                                    <div class="code-container">
                                      <div class="code-inputs">
                                        <input min="0" maxlength="1" type="number" name="code[]" id="" maxlength="1" class="listen-on-keyup txt-phone-verify" data-act="phone_verify_step" data-step="0">
                                        <input min="0" maxlength="1" type="number" name="code[]" id="" maxlength="1" class="listen-on-keyup txt-phone-verify" data-act="phone_verify_step" data-step="1">
                                        <input min="0" maxlength="1" type="number" name="code[]" id="" maxlength="1" class="listen-on-keyup txt-phone-verify" data-act="phone_verify_step" data-step="2">
                                        <input min="0" maxlength="1" type="number" name="code[]" id="" maxlength="1" class="listen-on-keyup txt-phone-verify" data-act="phone_verify_step" data-step="3">
                                        <input min="0" maxlength="1" type="number" name="code[]" id="" maxlength="1" class="listen-on-keyup txt-phone-verify" data-act="phone_verify_step" data-step="4">
                                        <input min="0" maxlength="1" type="number" name="code[]" id="" maxlength="1" class="listen-on-keyup txt-phone-verify" data-act="phone_verify_step" data-step="5">

                                      </div>
                                      <div class="invalid-code" style="display:none;">Invalid code</div>
                                    </div>

                                    <div class="m-stack__item m-stack__item--center verification-timer">
                                        <div class="" style="color:#fff">
                                            <span class="m-login__account-msg m-stack__item--center" style="color:#fff">
                                            The 6-Digit code will expire in <strong><span class='timer' data-minutes-left="300"></span></strong><br>
                                            Didn’t received the code? <span><a style="color:#fff" href="javascript:void(0);" class="btn-with-act" data-act="resend_verification_code">Resend</a></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-login__form-action">
                                        <div class="verify-message"></div>
                                        <button id="btn-verify" type="button" data-act="verify_phone"
                                            class="btn btn-with-act btn-focus m-btn m-btn--pill m-btn--custom m-btn--air btn-verify-phone">Verify</button>
                                    </div>
                                </form>

                                <div class="col-xl-6 authentication" style="visibility: hidden; opacity: 0">
                                    @if(!$yodlee["error"])
                                        @if(!empty($yodlee["user_session"]) && !empty($yodlee["access_token"]))
                                        <div class="div-yodlee-form-data">
                                            <form target="yodlee_iframe" action="{{url("yodlee_iframe")}}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="app" value="{{env("YODLEE_APP_ID")}}" />
                                                <input type="hidden" name="rsession" value="{{$yodlee["user_session"]}}" />
                                                <input type="hidden" name="token" value="{{$yodlee["access_token"]}}" />
                                                <input type="hidden" name="redirectReq" value="true" />
                                                <input type="hidden" name="extraParams" value="callback={{url("account")}}" />
                                                <input onclick="$('#modal-yodlee-add-bank').modal('show');" type="submit" style="opacity:0; visibility:hidden" name="submit" class="btn btn-primary btn-submit-yodlee-form"/>
                                            </form>
                                        </div>
                                        @endif
                                    @endif

                                </div>





                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="modal" tabindex="-1" role="dialog" id="modal-yodlee-add-bank">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" style="padding:2px">
                    <iframe style="min-height:70vh; width:100%; border:none; overflow:auto" name="yodlee_iframe" src="{{url("yodlee_iframe")}}" style="border:none; width:100%"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Page -->

    <!--begin:: Global Mandatory Vendors -->
    <script src="{{url('metronic/theme/default/dist/default/assets/')}}/vendors/jquery/dist/jquery.js" type="text/javascript"></script>

    <!--end:: Global Mandatory Vendors -->

    <!--begin:: Global Optional Vendors -->

    <script src="{{url('metronic/theme/default/dist/default/assets/')}}/vendors/jquery-validation/dist/jquery.validate.js"
        type="text/javascript"></script>

    <script src="{{url('metronic/theme/default/dist/default/assets/')}}/vendors/js/framework/components/plugins/forms/jquery-validation.init.js"
        type="text/javascript"></script>

    <!--end:: Global Optional Vendors -->

    <!--begin::Global Theme Bundle -->
    <script src="{{url('metronic/theme/default/dist/default/assets/vendors/base/vendors.bundle.js')}}"></script>
    <script src="{{url('metronic/theme/default/dist/default/assets')}}/demo/default/base/scripts.bundle.js" type="text/javascript"></script>

    <script type='text/javascript' src='https://cdn.yodlee.com/fastlink/v1/initialize.js'></script>


    <!--end::Global Theme Bundle -->

    <!--begin::Page Scripts -->
    <script src="{{url('js/jquery.simple.timer.js')}}" type="text/javascript"></script>
    <!--end::Page Scripts -->
    <script>
      (function($) {
        $('.timer').startTimer();
      })( jQuery )
    </script>

    <script type="text/javascript">
        var plastqUrl = "{{url("/")}}";
    </script>

    <script type="text/javascript">
        +function(a,p,P,b,y){
            a.appboy={};a.appboyQueue=[];
            for(var s="initialize destroy getDeviceId toggleAppboyLogging setLogger openSession changeUser requestImmediateDataFlush requestFeedRefresh subscribeToFeedUpdates requestContentCardsRefresh subscribeToContentCardsUpdates logCardImpressions logCardClick logCardDismissal logFeedDisplayed logContentCardsDisplayed logInAppMessageImpression logInAppMessageClick logInAppMessageButtonClick logInAppMessageHtmlClick subscribeToNewInAppMessages removeSubscription removeAllSubscriptions logCustomEvent logPurchase isPushSupported isPushBlocked isPushGranted isPushPermissionGranted registerAppboyPushMessages unregisterAppboyPushMessages submitFeedback trackLocation stopWebTracking resumeWebTracking wipeData ab ab.DeviceProperties ab.User ab.User.Genders ab.User.NotificationSubscriptionTypes ab.User.prototype.getUserId ab.User.prototype.setFirstName ab.User.prototype.setLastName ab.User.prototype.setEmail ab.User.prototype.setGender ab.User.prototype.setDateOfBirth ab.User.prototype.setCountry ab.User.prototype.setHomeCity ab.User.prototype.setLanguage ab.User.prototype.setEmailNotificationSubscriptionType ab.User.prototype.setPushNotificationSubscriptionType ab.User.prototype.setPhoneNumber ab.User.prototype.setAvatarImageUrl ab.User.prototype.setLastKnownLocation ab.User.prototype.setUserAttribute ab.User.prototype.setCustomUserAttribute ab.User.prototype.addToCustomAttributeArray ab.User.prototype.removeFromCustomAttributeArray ab.User.prototype.incrementCustomUserAttribute ab.User.prototype.addAlias ab.User.prototype.setCustomLocationAttribute ab.InAppMessage ab.InAppMessage.SlideFrom ab.InAppMessage.ClickAction ab.InAppMessage.DismissType ab.InAppMessage.OpenTarget ab.InAppMessage.ImageStyle ab.InAppMessage.TextAlignment ab.InAppMessage.Orientation ab.InAppMessage.CropType ab.InAppMessage.prototype.subscribeToClickedEvent ab.InAppMessage.prototype.subscribeToDismissedEvent ab.InAppMessage.prototype.removeSubscription ab.InAppMessage.prototype.removeAllSubscriptions ab.InAppMessage.prototype.closeMessage ab.InAppMessage.Button ab.InAppMessage.Button.prototype.subscribeToClickedEvent ab.InAppMessage.Button.prototype.removeSubscription ab.InAppMessage.Button.prototype.removeAllSubscriptions ab.SlideUpMessage ab.ModalMessage ab.FullScreenMessage ab.HtmlMessage ab.ControlMessage ab.Feed ab.Feed.prototype.getUnreadCardCount ab.ContentCards ab.ContentCards.prototype.getUnviewedCardCount ab.Card ab.ClassicCard ab.CaptionedImage ab.Banner ab.ControlCard ab.WindowUtils display display.automaticallyShowNewInAppMessages display.showInAppMessage display.showFeed display.destroyFeed display.toggleFeed display.showContentCards display.hideContentCards display.toggleContentCards sharedLib".split(" "),i=0;i<s.length;i++){for(var m=s[i],k=a.appboy,l=m.split("."),j=0;j<l.length-1;j++)k=k[l[j]];k[l[j]]=(new Function("return function "+m.replace(/\./g,"_")+"(){window.appboyQueue.push(arguments); return true}"))()}window.appboy.getUser=function(){return new window.appboy.ab.User};window.appboy.getCachedFeed=function(){return new window.appboy.ab.Feed};window.appboy.getCachedContentCards=function(){return new window.appboy.ab.ContentCards};(y=p.createElement(P)).type='text/javascript';
            y.src='https://js.appboycdn.com/web-sdk/2.3/appboy.min.js';
            y.async=1;(b=p.getElementsByTagName(P)[0]).parentNode.insertBefore(y,b)
        }(window, document, 'script');

        var appboy;
        // appboy.initialize('e0ba234c-86dc-41ef-9774-c6dfc46b4284');
        appboy.initialize('e0ba234c-86dc-41ef-9774-c6dfc46b4284', { baseUrl: 'https://sdk.iad-03.braze.com/api/v3' });
        appboy.toggleAppboyLogging();

        /*
        * If you have a unique identifier for this user (e.g. they are logged into your site) it's a good idea to call
        * changeUser here.
        * See https://js.appboycdn.com/web-sdk/latest/doc/module-appboy.html#.changeUser for more information.
        */

        let userIdentifier = "{{Auth::user()->id}}";
        console.log('userIdentifier', userIdentifier);
        appboy.changeUser(userIdentifier);

        var properties = {};
        // properties["details"] = @json(Auth::user());
        properties["details"] = "test";
        console.log('/registrationDetails' + properties);
        appboy.logCustomEvent("registrationDetails", properties);

        appboy.openSession();
    </script>

    <script src="{{url("/js/plastiq.js")}}" type="text/javascript"></script>

    <script>
    $(document).ready(function(){
        var optInterval;

        $('#modal-yodlee-add-bank').on('hidden.bs.modal', function () {
            window.location.href="{{url("account")}}";
        });

        //setTimeout(function(){
        //    $(".hidden-otp").val("123456");
        //}, 5000);

        checkOtp = function(){
            const code = $(".hidden-otp").val();
            const arrcode = code.split("");
            console.log($(".hidden-otp").val().length);
            if($(".hidden-otp").val().length == 0) return false;

            $(".txt-phone-verify[data-step='0']").val(arrcode[0]);
            $(".txt-phone-verify[data-step='1']").val(arrcode[1]);
            $(".txt-phone-verify[data-step='2']").val(arrcode[2]);
            $(".txt-phone-verify[data-step='3']").val(arrcode[3]);
            $(".txt-phone-verify[data-step='4']").val(arrcode[4]);
            $(".txt-phone-verify[data-step='5']").val(arrcode[5]);

            return true;

        }

        optInterval = setInterval(function(){

            if( checkOtp() ){
                clearInterval(optInterval);
            }
        }, 5000);
    });

    $(document).on("change, keyup", ".hidden-otp", function(){
        checkOtp();
    });

    </script>

</body>

<!-- end::Body -->

</html>
