@extends('layouts.main')
@section("main_content")


@section("subheader")
<style>
    .tab-text {
        font-size: 24px;
        color: #004183;
        font-weight: 400;
        font-family: 'Kanit';
    }

    .tab-text-link {
        text-decoration: none;
    }
</style>

<div class="m-subheader ">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-xl-9 col-lg-12">
            <div class=" invisible" style="height:63.7px;">

            </div>
        </div>
    </div>
</div>
@endsection
<!--Begin::Section-->
<div class="container-fluid ">
    <div class="m-portlet m-portlet--tabs my-account">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Bank
                    </h3>
                </div>
            </div>

            <div class="m-portlet__head-tools">
                <button class="btn btn-primary" style="height: 40px; margin: auto;">
                    Withdraw
                </button>
            </div>
        </div><!-- /.m-portlet__head -->

        <div class="m-portlet__body">
            <form id="frm-account-update">
                <div class="row">
                    <div class="col-xl-12">
                        <div style="text-align:right">
                            <button type="button"
                                onclick="$('.btn-submit-yodlee-form').trigger('click')"
                                class="btn btn-primary"
                                style="
                                    padding: 10px 10px 10px 10px;
                                    position:relative
                                ">
                                    Connect Your Account
                            </button>
                        </div>

                        <div class="div-yodlee-accounts"
                            data-usersession="@if(!empty($yodlee["user_session"])){{$yodlee["user_session"]}}@endif"
                            data-cobsession="@if(!empty($yodlee["cob_session"])){{$yodlee["cob_session"]}}@endif"
                            style="margin:10px 0px"
                            >
                        </div>
                    </div>
                    <!-- end:;column -->
                </div>
            </form>
        </div><!-- /.m-portlet__body -->
    </div>
</div>

@if(!$yodlee["error"])
    @if(!empty($yodlee["user_session"]) && !empty($yodlee["access_token"]))
    <form target="yodlee_iframe" action="{{url("yodlee_iframe")}}"
            method="POST">
            @csrf
            <input type="hidden" name="app" value="{{env("YODLEE_APP_ID")}}" />
            <input type="hidden" name="rsession" value="{{$yodlee["user_session"]}}" />
            <input type="hidden" name="token" value="{{$yodlee["access_token"]}}" />
            <input type="hidden" name="redirectReq" value="true" />
            <input type="hidden" name="extraParams" value="callback={{url("account")}}" />
            <input type="submit" onclick="$('#modal-yodlee-add-bank').modal('show');" style="opacity:0; visibility:hidden" name="submit" class="btn btn-primary btn-submit-yodlee-form"/>
        </form>
    @endif
@endif

<div class="modal" tabindex="-1" role="dialog" id="modal-yodlee-add-bank">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" style="padding:2px">
                <iframe style="min-height:70vh; width:100%; border:none; overflow:auto" name="yodlee_iframe" src="{{url("yodlee_iframe")}}" style="border:none; width:100%"></iframe>
            </div>
        </div>
    </div>
</div>

@endsection

@section("footer")
   @if($complete_registration == "true")
   <script type="text/javascript">
    $(document).ready(function(){
            setTimeout(function(){
                $('.btn-submit-yodlee-form').trigger('click');
            }, 100);
    });
   </script>
   @endif;
@endsection
