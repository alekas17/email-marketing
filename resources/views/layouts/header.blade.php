
<!DOCTYPE html>

<html lang="en">
	@php 
	if(!empty(app('request')->route()->getAction()["as"]) ) {
		$route_name = app('request')->route()->getAction()["as"];
	}else{
		$route_name = "";
	}
	@endphp

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="token" content="{{ session("web_access_token") }}">
		<meta name="route" content="{{ $route_name  }}">
		<title>Plastiq</title>
		<meta name="description" content="Latest updates and statistic charts">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
		<meta name="_token" content="{{ csrf_token() }}">
		<link rel="apple-touch-icon" sizes="180x180" href="{{url('/favicon/apple-touch-icon.png')}}">
		<link rel="icon" type="image/png" sizes="32x32" href="{{url('/favicon/favicon-32x32.png')}}">
		<link rel="icon" type="image/png" sizes="16x16" href="{{url('/favicon/favicon-16x16.png')}}">
		<link rel="manifest" href="{{url('/favicon/site.webmanifest')}}">
		<link rel="mask-icon" href="{{url('/favicon/safari-pinned-tab.svg" color="#5bbad5')}}">
		<link rel="shortcut icon" href="{{url('/favicon/favicon.png')}}">
		<meta name="msapplication-TileColor" content="#2b5797">
		<meta name="msapplication-config" content="{{url('/favicon/browserconfig.xml')}}">
		<meta name="theme-color" content="#ffffff">
		<!--begin::Web font -->
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>

		<script>
			WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700","Kanit:300,400,500"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

		<!--end::Web font -->
		<!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/> -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.theme.default.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.40/css/uikit.min.css">
		

		<!--begin::Global Theme Styles -->
        <link href="{{url("/metronic/theme/default/dist/default/")}}/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link href="{{url("/metronic/theme/default/dist/default/")}}/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

		<!--end::Global Theme Styles -->

		<!--begin::Page Vendors Styles -->
		<link href="{{url("/metronic/theme/default/dist/default/")}}/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />

		<!--RTL version:<link href="assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
		<link rel="stylesheet" href="{{url('css/app.css')}}">
		<!--end::Page Vendors Styles -->

		<script>
		!function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on"];analytics.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);analytics.push(e);return analytics}};for(var t=0;t<analytics.methods.length;t++){var e=analytics.methods[t];analytics[e]=analytics.factory(e)}analytics.load=function(t,e){var n=document.createElement("script");n.type="text/javascript";n.async=!0;n.src="https://cdn.segment.com/analytics.js/v1/"+t+"/analytics.min.js";var a=document.getElementsByTagName("script")[0];a.parentNode.insertBefore(n,a);analytics._loadOptions=e};analytics.SNIPPET_VERSION="4.1.0";
		analytics.load("eQ9pfhbiT0R1oQHVe34Gepsrg4f5qwtL");
		analytics.page();
		}}();
		</script>
		
	</head>
