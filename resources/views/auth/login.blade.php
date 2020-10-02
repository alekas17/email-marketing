<!DOCTYPE html>


<html lang="en">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>{{ config('app.name', 'Laravel') }}</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" href="{{url('/favicon/favicon.png')}}">
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
		<link href="{{url('metronic/theme/default/dist/default/assets')}}/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="{{url('metronic/theme/default/dist/default/assets')}}/demo/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link rel="stylesheet" href="{{url('css/login.css')}}">

		<script>
		!function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on"];analytics.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);analytics.push(e);return analytics}};for(var t=0;t<analytics.methods.length;t++){var e=analytics.methods[t];analytics[e]=analytics.factory(e)}analytics.load=function(t,e){var n=document.createElement("script");n.type="text/javascript";n.async=!0;n.src="https://cdn.segment.com/analytics.js/v1/"+t+"/analytics.min.js";var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(n,a);analytics._loadOptions=e};analytics.SNIPPET_VERSION="4.1.0";
		analytics.load("eQ9pfhbiT0R1oQHVe34Gepsrg4f5qwtL");
		analytics.page();
		}}();
		</script>
		<style type="text/css">
		.logo-mobile{
			display:none
		}
		@media only screen and (max-width: 480px) {
			.m-login__content{
				display:none !important;
			}
			.m-login__aside{
				margin:auto !important;
			}

			.logo-mobile{
				display:block;
				margin:auto;
			}
			.logo-desktop{
				display:none;
			}


		}
		</style>
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body id="login" class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-grid--tablet-and-mobile m-grid--hor-tablet-and-mobile m-login m-login--1 m-login--signin" id="m_login">
				<div class="m-grid__item m-grid__item--order-tablet-and-mobile-2 m-login__aside">
					<div class="m-stack m-stack--hor m-stack--desktop">
						<div class="m-stack__item m-stack__item--fluid">
							<div class="m-login__wrapper">
								<div class="m-login__logo">
									<a href="#">
                                        <img src="{{ url('images/plastiq-it-logo-purple.png') }}" alt="" width="207px">
									</a>
								</div>
								<div class="m-login__signin">
									<div class="m-login__head m--align-center">
                                        <h3 class="m-login__title">Sign in or Create a New Account</h3>
                                        <!-- @if ($errors->has('email'))
                                        <div class="m-alert m-alert--outline alert alert-danger alert-dismissible animated fadeIn" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('email') }}
                                                </span>
                                        </div>
										@endif -->
										<span class="m-login__info">Your email address will be used for login and receiving updates</span>
                                    </div>
                                <form class="m-login__form m-form" method="POST" action="{{ route('validate_email') }}">
                                    @csrf
										<div class="form-group m-form__group">
                                            <!-- <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus> -->
                                            <input id="email" placeholder="Email Address" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} m-input email" name="email" value="{{ old('email') }}" required autofocus >

										</div>
										<!-- <div class="form-group m-form__group">
                                            <input id="password" placeholder="Password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} m-input pw" name="password" required>
										</div> 
										<div class="row m-login__form-sub">
											<div class="col m--align-left">
												<label class="m-checkbox m-checkbox--focus">
                                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
													<span></span>
                                                </label>
											</div>
											<div class="col m--align-right">
												<a href="{{ route('password.request') }}" class="m-link">Forget Password?</a>
											</div>
										</div> -->
										<div class="m-login__form-action">
											<button type="submit" id="btn-submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">Next</button>
										</div>
									</form>
								</div>
								<!-- <div class="m-login__signup">
									<div class="m-login__head">
										<h3 class="m-login__title">Sign Up</h3>
										<div class="m-login__desc">Enter your details to create your account:</div>
									</div>
									<form class="m-login__form m-form" action="">
										<div class="form-group m-form__group">
											<input class="form-control m-input" type="text" placeholder="Fullname" name="fullname">
										</div>
										<div class="form-group m-form__group">
											<input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
										</div>
										<div class="form-group m-form__group">
											<input class="form-control m-input" type="password" placeholder="Password" name="password">
										</div>
										<div class="form-group m-form__group">
											<input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="rpassword">
										</div>
										<div class="row form-group m-form__group m-login__form-sub">
											<div class="col m--align-left">
												<label class="m-checkbox m-checkbox--focus">
													<input type="checkbox" name="agree"> I Agree the <a href="#" class="m-link m-link--focus">terms and conditions</a>.
													<span></span>
												</label>
												<span class="m-form__help"></span>
											</div>
										</div>
										<div class="m-login__form-action">
											<button id="m_login_signup_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">Sign Up</button>
											<button id="m_login_signup_cancel" class="btn btn-outline-focus  m-btn m-btn--pill m-btn--custom">Cancel</button>
										</div>
									</form>
								</div>
								<div class="m-login__forget-password">
									<div class="m-login__head">
										<h3 class="m-login__title">Forgot Password</h3>
										<div class="m-login__desc">We will send you instructions on how to reset your password by email.</div>
									</div>
									<form class="m-login__form m-form" action="">
										<div class="form-group m-form__group">
											<input class="form-control m-input email" type="text" placeholder="Email Address" name="email" id="m_email" autocomplete="off">
										</div>
										<div class="m-login__form-action">
											<button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">submit</button>
											<button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">Cancel</button>
										</div>
									</form>
								</div> -->
							</div>
                            <!-- <div class="m-stack__item m-stack__item--center" style="margin-top:20px;">
                                <div class="m-login__account">
                                    <span class="m-login__account-msg">
                                        Don't have an account yet?
                                    </span>
                                    <a href="{{  url('signup ') }}" class="m-link m-link--focus m-login__account-link">Sign Up</a>
                                </div>
                            </div> -->
						</div>
					</div>
				</div>
				<div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content m-grid-item--center" style="background: url({{url('/images/login-bg.png')}}) no-repeat left top/cover;">
					<div class="m-grid__item">
                        <!--
						<h3 class="m-login__welcome">#rewardingAF</h3>
						<p class="m-login__msg">
							Earn Cash Rewards From Your Favourite Brands!
                        </p>
                        -->
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!--begin:: Global Mandatory Vendors -->
		<script src="{{url('metronic/theme/default/dist/default/assets/')}}/vendors/jquery/dist/jquery.js" type="text/javascript"></script>

		<!--end:: Global Mandatory Vendors -->

    <!--begin:: Global Optional Vendors -->

        <script src="{{url('metronic/theme/default/dist/default/assets/')}}/vendors/jquery-validation/dist/jquery.validate.js" type="text/javascript"></script>

		<script src="{{url('metronic/theme/default/dist/default/assets/')}}/vendors/js/framework/components/plugins/forms/jquery-validation.init.js" type="text/javascript"></script>

		<!--end:: Global Optional Vendors -->

        <!--begin::Global Theme Bundle -->
        <script src="{{url('metronic/theme/default/dist/default/assets/vendors/base/vendors.bundle.js')}}"></script>
        <script src="{{url('metronic/theme/default/dist/default/assets')}}/demo/default/base/scripts.bundle.js" type="text/javascript"></script>


		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts -->
		<script src="{{url('metronic/theme/default/dist/default/assets')}}/snippets/custom/pages/user/login.js" type="text/javascript"></script>
        <!--end::Page Scripts -->

		<script type="text/javascript">
		$(document).ready(function(){
			$(".m-login__form").on("submit", function(){
				$("#btn-submit").fadeTo("fast", .3).html("<i class='fa fa-spin fa-spinner'></i>")
			});
		});
		</script>
	</body>

	<!-- end::Body -->
</html>
