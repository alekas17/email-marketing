<!DOCTYPE html>


<html lang="en">

<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

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
    input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    input[type="number"] {
        -moz-appearance: textfield;
    }
    .modal {
        -webkit-overflow-scrolling: touch;
    }

    @media only screen and (max-width: 480px) {
        .hide-mobile{
            display:none !important;
        }
    }
    </style>
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body id="login" class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin"
            id="m_login">
            <div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
                <div class="m-stack m-stack--hor m-stack--desktop">
                    <div class="m-stack__item m-stack__item--fluid">
                        <div class="m-login__wrapper">
                            <div class="m-login__logo">
                                <a href="#">
                                    <img src="{{ url('images/logo-purple.png') }}" alt="" width="207px">
                                </a>
                            </div>
                            <div class="m-login__signup phone-verification" style="display:block;">
                                <div class="m-login__head">
                                    <h3 class="m-login__title">Phone Number Verification</h3>
                                    <div class="m-login__desc">A 6-digit code has been sent to <br>
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
                                            <a href="javascript:void(0);" class="btn-with-act" data-act="change_verify_phone_number">Change</a>
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
                                        <div class="">
                                            <span class="m-login__account-msg m-stack__item--center">
                                            The 6-Digit code will expire in <strong><span class='timer' data-minutes-left="300"></span></strong><br>
                                            Didn’t received the code? <span><a href="javascript:void(0);" class="btn-with-act" data-act="resend_verification_code">Resend</a></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="m-login__form-action">
                                        <div class="verify-message"></div>
                                        <button id="btn-verify" type="button" 
                                            style="background: linear-gradient(to right, #a84bdd 0%, #a84bdd 100%);"
                                            data-act="verify_phone" 
                                            class="btn btn-with-act btn-focus m-btn m-btn--pill m-btn--custom m-btn--air btn-verify-phone">Verify</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="hide-mobile m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content m-grid-item--center"
                style="background: url({{url('/images/login-bg.png')}}) no-repeat left top/cover;">
                <div class="m-grid__item">
                    <h3 class="m-login__welcome">Cash back automatically.</h3>
                    <p class="m-login__msg">
                        It’s not points. It’s not coupons. It’s just cold, hard cash.
                    </p>
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
        var optInterval;
        var plastqUrl = "{{url("/")}}";   
        $(document).ready(function(){

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

    <script src="{{url("/js/plastiq.js")}}" type="text/javascript"></script>
    

</body>

<!-- end::Body -->

</html>
