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

		<!--end::Web font -->

		<!--end:: Global Optional Vendors -->

        <!--begin::Global Theme Styles -->
        <link rel="stylesheet" href="{{url('metronic/theme/default/dist/default/assets/vendors/base/vendors.bundle.css')}}">
		<link href="{{url('metronic/theme/default/dist/default/assets')}}/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{url('css/login.css')}}">

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
                                        <img src="{{ url('images/logo-purple.png') }}" alt="" width="207px">
									</a>
								</div>
								<div class="m-login__signin">
									<div class="m-login__head">
                                        <h3 class="m-login__title">Thank you!</h3>
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

        <!-- end:: Page -->

		<script >
            window.ReactNativeWebView.postMessage("done")
		</script>
	</body>
	<!-- end::Body -->
</html>
