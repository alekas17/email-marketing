@include('layouts.header')

@yield("styles_and_js")
<!-- end::Head -->

<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile
m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas
m-footer--push m-aside--offcanvas-default
@if(\Auth::user()->user_type==1) {{"plastiq-admin"}} @endif
">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">

        @include("layouts.topbar")

        <!-- END: Header -->

        <!-- begin::Body -->
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

            <div class="m-grid__item m-grid__item--fluid m-wrapper">

                <!-- BEGIN: Subheader -->
                @yield("subheader")
                <!-- END: Subheader -->
                <div class="m-content">
                    @yield("main_content")

                </div>
            </div>
            {{-- m_modal_1 --}}
            <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="padding-right:0;">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="my-card-container">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          close
                        </button>
                        <div class="card-col new-card" style="position:relative">
                            <h2>Add a Card</h2>
                            <div class="card-board">
                                <a href="#" class="add-card btn-with-act" data-act="preload_add_card_form" data-type="add">
                                    <span class="flaticon-plus"></span>
                                    Add New Card
                                </a>
                            </div>

                        </div>
                        <div style="display:flex;  position:relative; display:contents;">
                                <!-- <button type="button" class="btn btn-with-act btn-link btn-card-carousel-prev" style="display:none" data-act="cards_slider_prev"><i class="fa fa-angle-left"></i></button> -->

                                <div class="card-list pop-cards-list">

                                </div>
                                    <!-- <button type="button" class="btn btn-with-act btn-link btn-card-carousel-next" style="display:none" data-act="cards_slider_next"><i class="fa fa-angle-right"></i></button> -->
                        </div>

                    </div>
                    <div class="card-management" style="display:none;">
                    </div>
                </div>
              </div>
            </div>
            {{-- m_modal_1 --}}
        </div>

        <!-- end:: Body -->

        @include("layouts.footer")

    </div>

    <div class="modal fade modal_remove_card" id="remove" role="dialog" aria-labelledby="removeModal" >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <img src="{{ url('images/remove-card-icon.png') }}" alt="">
                <h3>Do you want to remove this card?</h3>
                <div class="card-details">**** **** **** <span class="last4">1001</span></div>
                <div class="btn-actions">
                    <button class="btn-yes btn-with-act" data-act="delete_customer_card">
                        yes
                    </button>
                    <button class="btn-no" data-dismiss="modal" aria-label="Close">
                        no
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- end:: Page -->

    @include("layouts.quicksidebar")
    <!-- end::Quick Sidebar -->

    <!-- begin::Scroll Top -->
    <div id="m_scroll_top" class="m-scroll-top">
        <i class="la la-arrow-up"></i>
    </div>

    <!-- end::Scroll Top -->
    <!--begin::Global Theme Bundle -->



    <!--end::Global Theme Bundle -->

    <!--begin::Page Vendors -->
    <script src="{{url("/metronic/theme/default/dist/default/")}}/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js"></script>
    <script src="{{url("/metronic/theme/default/dist/default/")}}/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>


    <script src="{{url("/metronic/theme/default/dist/default/")}}/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>

    <!--end::Page Vendors -->

    <!--begin::Page Scripts -->
    <script src="{{url("/metronic/theme/default/dist/default/")}}/assets/app/js/dashboard.js" type="text/javascript"></script>
    <script src="{{url("metronic/theme/default/dist/default/assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js")}}" type="text/javascript"></script>
    <script src="{{url("metronic/theme/default/dist/default/assets/demo/default/custom/crud/forms/widgets/bootstrap-datepicker.js")}}" type="text/javascript"></script>


    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script type="text/javascript" src="https://js.stripe.com/v1/"></script>
    <script type="text/javascript">
        var plastqUrl = "{{url("/")}}";
        Stripe.setPublishableKey("{{env("STRIPE_PK")}}");
    </script>

    <script type="text/javascript">
        +function(a,p,P,b,y){
            a.appboy={};a.appboyQueue=[];
            for(var s="initialize destroy getDeviceId toggleAppboyLogging setLogger openSession changeUser requestImmediateDataFlush requestFeedRefresh subscribeToFeedUpdates requestContentCardsRefresh subscribeToContentCardsUpdates logCardImpressions logCardClick logCardDismissal logFeedDisplayed logContentCardsDisplayed logInAppMessageImpression logInAppMessageClick logInAppMessageButtonClick logInAppMessageHtmlClick subscribeToNewInAppMessages removeSubscription removeAllSubscriptions logCustomEvent logPurchase isPushSupported isPushBlocked isPushGranted isPushPermissionGranted registerAppboyPushMessages unregisterAppboyPushMessages submitFeedback trackLocation stopWebTracking resumeWebTracking wipeData ab ab.DeviceProperties ab.User ab.User.Genders ab.User.NotificationSubscriptionTypes ab.User.prototype.getUserId ab.User.prototype.setFirstName ab.User.prototype.setLastName ab.User.prototype.setEmail ab.User.prototype.setGender ab.User.prototype.setDateOfBirth ab.User.prototype.setCountry ab.User.prototype.setHomeCity ab.User.prototype.setLanguage ab.User.prototype.setEmailNotificationSubscriptionType ab.User.prototype.setPushNotificationSubscriptionType ab.User.prototype.setPhoneNumber ab.User.prototype.setAvatarImageUrl ab.User.prototype.setLastKnownLocation ab.User.prototype.setUserAttribute ab.User.prototype.setCustomUserAttribute ab.User.prototype.addToCustomAttributeArray ab.User.prototype.removeFromCustomAttributeArray ab.User.prototype.incrementCustomUserAttribute ab.User.prototype.addAlias ab.User.prototype.setCustomLocationAttribute ab.InAppMessage ab.InAppMessage.SlideFrom ab.InAppMessage.ClickAction ab.InAppMessage.DismissType ab.InAppMessage.OpenTarget ab.InAppMessage.ImageStyle ab.InAppMessage.TextAlignment ab.InAppMessage.Orientation ab.InAppMessage.CropType ab.InAppMessage.prototype.subscribeToClickedEvent ab.InAppMessage.prototype.subscribeToDismissedEvent ab.InAppMessage.prototype.removeSubscription ab.InAppMessage.prototype.removeAllSubscriptions ab.InAppMessage.prototype.closeMessage ab.InAppMessage.Button ab.InAppMessage.Button.prototype.subscribeToClickedEvent ab.InAppMessage.Button.prototype.removeSubscription ab.InAppMessage.Button.prototype.removeAllSubscriptions ab.SlideUpMessage ab.ModalMessage ab.FullScreenMessage ab.HtmlMessage ab.ControlMessage ab.Feed ab.Feed.prototype.getUnreadCardCount ab.ContentCards ab.ContentCards.prototype.getUnviewedCardCount ab.Card ab.ClassicCard ab.CaptionedImage ab.Banner ab.ControlCard ab.WindowUtils display display.automaticallyShowNewInAppMessages display.showInAppMessage display.showFeed display.destroyFeed display.toggleFeed display.showContentCards display.hideContentCards display.toggleContentCards sharedLib".split(" "),i=0;i<s.length;i++){for(var m=s[i],k=a.appboy,l=m.split("."),j=0;j<l.length-1;j++)k=k[l[j]];k[l[j]]=(new Function("return function "+m.replace(/\./g,"_")+"(){window.appboyQueue.push(arguments); return true}"))()}window.appboy.getUser=function(){return new window.appboy.ab.User};window.appboy.getCachedFeed=function(){return new window.appboy.ab.Feed};window.appboy.getCachedContentCards=function(){return new window.appboy.ab.ContentCards};(y=p.createElement(P)).type='text/javascript';
            y.src='https://js.appboycdn.com/web-sdk/2.3/appboy.min.js';
            y.async=1;(b=p.getElementsByTagName(P)[0]).parentNode.insertBefore(y,b)
        }(window, document, 'script');

        var appboy;
        appboy.initialize('e0ba234c-86dc-41ef-9774-c6dfc46b4284',
            { baseUrl: 'https://sdk.iad-03.braze.com/api/v3' }
        );
        appboy.toggleAppboyLogging();

        appboy.changeUser("{{auth::user()->id}}");
        appboy.getUser().setEmail("{{auth::user()->email}}");
        appboy.getUser().setFirstName("{{auth::user()->name}}");
        appboy.getUser().setLastName("{{auth::user()->last_name}}");
        appboy.getUser().setGender("{{auth::user()->gender[0]}}");
        appboy.getUser().setPhoneNumber("{{auth::user()->phone}}");

        appboy.getUser().setCustomUserAttribute(
            "age_bracket",
            "{{auth::user()->age_bracket}}"
        );

        appboy.openSession();
    </script>

    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js" ></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.40/js/uikit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.40/js/uikit-icons.min.js"></script>
     <script src="{{url("/js/flot.bundle.js")}}" type="text/javascript"></script>
    {{-- <script src="{{url("/js/flotcharts.js")}}" type="text/javascript"></script> --}}
    <script src="{{url("/js/plastiq.js")}}" type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            $('#m_modal_1').on('show.bs.modal', function (e) {
                $('body').addClass('custom-modal')
            });

            $('#remove').on('show.bs.modal', function (e) {
                $('body').addClass('d-backdrop');
            });

            $('#remove').on('hidden.bs.modal', function (e) {
                $('body').removeClass('d-backdrop');
            });

            // payments/create .select-recipient
            // Set selected option to active
            $('.select-recipient .options label').click(function() {
                $('.options .radio-wrapper').removeClass('active');
                $(this).parent().addClass('active');
            });

            // payments/create next button

            $('.step-nav .btn-back, .edit-payment-details ').click( function (e) {
                e.preventDefault();
                if ( $('.form-container .active').prev().hasClass('step') ) {
                    $('.form-container .active').addClass('d-none')
                        .removeClass('active')
                        .prev()
                        .removeClass('d-none')
                        .addClass('active');
                    $('.steps .active').removeClass('active')
                        .prev()
                        .removeClass('is-complete')
                        .addClass('active')
                }

            });

            $(".edit-payment-details").click( function(e){
                e.preventDefault();
                $(".step-nav").show();
            });

            /*
            $('.step-nav .btn-next').click( function (e) {
                e.preventDefault();

                if ( $('.form-container .active').next().hasClass('step') ) {
                    $('.form-container .active').addClass('d-none')
                        .removeClass('active')
                        .next()
                        .removeClass('d-none')
                        .addClass('active');

                    $('.steps .active').addClass('is-complete')
                        .removeClass('active')
                        .next()
                        .addClass('active')

                    if( $('.payment-review').hasClass('active') ) {
                        $(this).parent().hide();
                    }
                }


            });
            */
        });
    </script>

    <!--end::Page Scripts -->

    @yield("footer")

</body>

<!-- end::Body -->
</html>
