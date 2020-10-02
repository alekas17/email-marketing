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
                                    <img src="{{ url('images/logo-new.png') }}" alt="">
                                </a>
                            </div>
                            <div class="m-login__signup verification-success" style="display:block;">
                                <div class="m-login__head">
                                    <h3 class="m-login__title">Phone Number Verification</h3>
                                    <img src="{{url('/images/congrats-icon.png')}}" alt="">
                                    <div class="congrats">
                                      <h2>Congratulations!</h2>
                                      <p>Your Phone Number has been verified sucessfully</p>
                                      <a href="#" id="btn-goto" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">GO TO ACCOUNT</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content m-grid-item--center"
                style="background: url({{url('/images/login-bg.png')}}) no-repeat left top/cover;">
                <div class="m-grid__item">
                    <h3 class="m-login__welcome">Pay Virtually Any Bill <br>With Credit Cards</h3>
                    <p class="m-login__msg">
                        Lorem ipsum dolor sit amet, coectetuer adipiscing<br>elit sed diam nonummy et nibh euismod
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

    
</body>

<!-- end::Body -->

</html>
