<!-- BEGIN: Header -->
<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            {{-- BEGIN: BRAND --}}
            <div class="m-stack__item m-brand">
                <div class="m-stack m-stack--ver m-stack--general">

                    <div class="m-stack__item m-stack__item--middle m-brand__tools">


                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>
            {{-- BEGIN: BRAND --}}
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

                <!-- BEGIN: Horizontal Menu -->
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
                    <a  id="logo"
                        @if(empty($is_cashback))
                        data-toggle="modal" data-target="#m_modal_1"
                        @else
                        onclick="window.location.href='{{url("/")}}'"
                        @endif
                    >
                        <img src="{{ url('images/plastiq-it-logo-white.png') }}" alt="" style="max-width:180px;">
                    </a>
                </div>

                <!-- END: Horizontal Menu -->

                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            @php /*
                            <li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light" m-dropdown-toggle="click" id="m_quicksearch"
                             m-quicksearch-mode="dropdown" m-dropdown-persistent="1">
                                <a href="{{url("/payments/create")}}" class="m-nav__link " id="m_topbar_make-payment">
                                    <span>Make a Payment</span>
                                </a>
                            </li>
                            */@endphp
                            <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click"
                             m-dropdown-persistent="1">
                                <a  href="{{url("/")}}" class="m-nav__link " id="m_topbar_manage">
                                    <span>Manage</span>
                                </a>

                                <div class="m-dropdown__wrapper" style="width: 283px !important;">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="color:#fff; "></span>
                                    <div class="m-dropdown__inner">

                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    @php /*
                                                    <li class="m-nav__item">
                                                        <a href="{{url('/payments/manage')}}" class="m-nav__link">
                                                            <span class="m-nav__link-text">Manage Payments</span>
                                                        </a>
                                                    </li>
                                                    */ @endphp

                                                    <li class="m-nav__item">
                                                        <a href="{{url('/cashbacks')}}" class="m-nav__link">
                                                            <span class="m-nav__link-text">Manage Cashbacks</span>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </li>
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                             m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-topbar__userpic">
                                        <img src="{{url('/images/user.png')}}" class="m--img-rounded m--marginless" alt="" />
                                    </span>
                                    <span class="m-topbar__username m--hide">Nick</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="color:#fff;"></span>
                                    <div class="m-dropdown__inner">
                                        <!-- <div class="m-dropdown__header m--align-center" style="background: url({{url("/metronic/theme/default/dist/default/")}}/assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic">
                                                    <img src="{{url('/images/user.png')}}" class="m--img-rounded m--marginless" alt="" />


                                                </div>
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500">Mark Andre</span>
                                                    <a href="" class="m-card-user__email m--font-weight-300 m-link">mark.andre@gmail.com</a>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__section m--hide">
                                                        <span class="m-nav__section-text">Section</span>
                                                    </li>
                                                    <!-- <li class="m-nav__item">
                                                        <a href="header/profile.html" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                            <span class="m-nav__link-title">
                                                                <span class="m-nav__link-wrap">
                                                                    <span class="m-nav__link-text">My Profile</span>
                                                                    <span class="m-nav__link-badge"><span class="m-badge m-badge--success">2</span></span>
                                                                </span>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="header/profile.html" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-share"></i>
                                                            <span class="m-nav__link-text">Activity</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="header/profile.html" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                            <span class="m-nav__link-text">Messages</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__separator m-nav__separator--fit">
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="header/profile.html" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-info"></i>
                                                            <span class="m-nav__link-text">FAQ</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{{url('/payments/manage')}}" class="m-nav__link">
                                                            <i class="m-nav__link-icon fa fa-bars"></i>
                                                            <span class="m-nav__link-text">Manage Payments</span>
                                                        </a>
                                                    </li>-->
                                                    @if(\Auth::user()->user_type==1)
                                                    <li class="m-nav__item">
                                                        <a href="{{url('/administrator')}}" class="m-nav__link">
                                                            <i class="m-nav__link-icon fa fa-cog"></i>
                                                            <span class="m-nav__link-text">Administrator</span>
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{{url('/administrator/cashbacks')}}" class="m-nav__link">
                                                            <i class="m-nav__link-icon fa fa-money-bill-wave-alt"></i>
                                                            <span class="m-nav__link-text">Cashbacks</span>
                                                        </a>
                                                    </li>
                                                    @endif
                                                    <li class="m-nav__item">
                                                        <a href="{{url('/account')}}" class="m-nav__link">
                                                            <i class="m-nav__link-icon fa fa-user"></i>
                                                            <span class="m-nav__link-text">Account</span>
                                                        </a>
                                                    </li>

                                                    @if(!empty(\Auth::user()->merchant))
                                                        @if(!empty(\Auth::user()->merchant->id))
                                                        <li class="m-nav__item">
                                                        <a onclick="Plastiq.Merchant.Offers({{\Auth::user()->merchant->id}});" class="m-nav__link">
                                                                <i class="m-nav__link-icon fa fa-tags"></i>
                                                                <span class="m-nav__link-text">Manage Offers</span>
                                                            </a>
                                                        </li>
                                                        @endif
                                                    @endif

                                                    <li class="m-nav__item">
                                                        <a href="{{ route('bank.index.html') }}" class="m-nav__link">
                                                            <i class="m-nav__link-icon fa fa-credit-card"></i>
                                                            <span class="m-nav__link-text">Bank Details</span>
                                                        </a>
                                                    </li>

                                                    <li class="m-nav__separator m-nav__separator--fit">
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{{url("/logout")}}" class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>

                <!-- END: Topbar -->

            </div>


        </div>
    </div>
    <div class="my-card top-my-card"
        @if(empty($is_cashback))
        data-toggle="modal" data-target="#m_modal_1"
        @else
        onclick="window.location.href='{{url("/")}}'"
        @endif
        data-iscashback=" @if(!empty($is_cashback)) {{"1"}} @else{{"0"}} @endif">

        <!-- .bottom-holder -->
        <h5 style='text-align:center;color: #fff;font-size: 20px;'>Loading ...</h5>
    </div>
</header>

@if(!empty(\Auth::user()->merchant))
    @if(!empty(\Auth::user()->merchant->id))
    <div class="modal" tabindex="-1" role="dialog" id="div-manage-offers">
        <div class="modal-dialog modal-lg" role="document" style="max-width:80%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Offers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    @endif
@endif
