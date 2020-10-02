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
		<link href="{{url('metronic/theme/default/dist/default/assets')}}/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="{{url('metronic/theme/default/dist/default/assets')}}/demo/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
        <link rel="stylesheet" href="{{url(mix('css/login.css'))}}">
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
                                        <img src="{{ url('images/logo-new.png') }}" alt="">
									</a>
								</div>
								<div class="m-login__forget-password" style="display:block;">
									<div class="m-login__head">
										<h3 class="m-login__title">Forgot Password</h3>
                                        <div class="m-login__desc">We will send you instructions on how to reset your password by email.</div>
                                        @if ($errors->has('email'))
                                        <div class="m-alert m-alert--outline alert alert-danger alert-dismissible animated fadeIn" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $errors->first('email') }}
                                                </span>
                                        </div>
                                        @endif
									</div>
									<!-- <form class="m-login__form m-form" action="">
										<div class="form-group m-form__group">
											<input class="form-control m-input email" type="text" placeholder="Email Address" name="email" id="m_email" autocomplete="off">
										</div>
										<div class="m-login__form-action">
											<button id="m_login_forget_password_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">submit</button>
											<button id="m_login_forget_password_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">Cancel</button>
										</div>
									</form> -->
                                    <form class="m-login__form m-form" method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="form-group m-form__group">
                                            <input id="m_email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} m-input email" name="email" value="{{ old('email') }}" autocomplete="off" placeholder="{{ __('E-Mail Address') }}" required>
										</div>
										<div class="m-login__form-action">
											<button type="submit" id="btn-submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">submit</button>
											<a href="{{route('login')}}" id="btn-cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">Cancel</a>
										</div>

                                        <!-- <div class="form-group row">
                                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Send Password Reset Link') }}
                                                </button>
                                            </div>
                                        </div> -->
                                    </form>
								</div>
							</div>
                            <div class="m-stack__item m-stack__item--center" style="margin-top:20px;">
                                <div class="m-login__account">
                                    <span class="m-login__account-msg">
                                        Don't have an account yet?
                                    </span>
                                    <a href="{{  route('register') }}" class="m-link m-link--focus m-login__account-link">Sign Up</a>
                                </div>
                            </div>
						</div>
					</div>
				</div>
				<div class="m-grid__item m-grid__item--fluid m-grid m-grid--center m-grid--hor m-grid__item--order-tablet-and-mobile-1	m-login__content m-grid-item--center" style="background: url({{url('/images/login-bg.png')}}) no-repeat left top/cover;">
					<div class="m-grid__item">
						<h3 class="m-login__welcome">Plastiq allows you to pay any bill<br>with a credit card</h3>
						<p class="m-login__msg">
							Maximise your cash and watch your credit card rewards skyrocket
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