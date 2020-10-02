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
                                        <img src="{{ url('images/logo-purple.png') }}" alt="" width="207px">
									</a>
								</div>
								<div class="m-login__signin">
									<div class="m-login__head">
                                        <h4 class="m-login__title">Redirecting...</h4>
                                        <a style="text-align: center;" onclick="$("#btn-submit").trigger("click");">
                                            Please click here to redirect manually!
                                        </a>
                                    </div>
                                    <form class="m-login__form m-form"
                                        action="{{env("YODLEE_NODE_URL")}}"
                                        method="POST"
                                        id="yodlee-form"
                                    >
                                        <input type="hidden" name="app" value="{{env("YODLEE_APP_ID")}}" />
                                        <input type="hidden" name="rsession" value="{{$rsession}}" />
                                        <input type="hidden" name="token" value="{{$token}}" />
                                        <input type="hidden" name="redirectReq" value="true" />
                                        <input type="hidden" name="extraParams" value="callback={{route("api.user.account.connect.action", ["action" => "done", "userID" => $userID])}}" />
                                        <input
                                            style="display: none"
                                            type="submit"
                                            name="submit"
                                            id="btn-submit"
                                        />

                                    </form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!--begin:: Global Mandatory Vendors -->
		<script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"
        >
        </script>

		<!--end:: Global Mandatory Vendors -->
		<script type="text/javascript">
		$(document).ready(function(){
			$("#btn-submit").trigger("click");
		});
		</script>
	</body>
	<!-- end::Body -->
</html>
