@extends('layouts.main')
@section("main_content")


@section("subheader")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
                        Profile
                    </h3>
                </div>
            </div>
        </div><!-- /.m-portlet__head -->

        <div class="m-portlet__body">
            <form id="frm-account-update">
                <div class="row">
                    <div class="col-xl-6 account-details">
                        <div>
                            <h3>ACCOUNT DETAILS</h3>
                            <div class="form-group d-flex justify-content-between">
                                <label class="col-form-label">Name:</label>
                                <div class="input-wrapper d-flex justify-content-between two-col">
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{$user->name}}" />
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{$user->last_name}}" />
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <label for="">Phone Number</label>
                                <div class="input-wrapper">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{$user->phone}}" />
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <label for="">DOB: <small>* Optional</small></label>
                                <div class="input-wrapper">
                                    <input 
                                        type="text" 
                                        name="birthday" 
                                        id="birthday"
                                        class="form-control" 
                                        value="{{($user->birthday) ? Carbon\Carbon::parse($user->birthday)->format('d-m-Y') : "" }}" 
                                        placeholder="DD-MM-YYYY"
                                    />
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <label for="">Postcode: <small>* Optional</small></label>
                                <div class="input-wrapper">
                                    <input type="text" name="postal" class="form-control" placeholder="1234" value="{{$user->postal}}" />
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <label for="">Email Address</label>
                                <div class="input-wrapper">
                                    <button class="btn-change-email">change email</button>
                                    <div class="hid change-email-address">
                                        <input type="hidden" name="is_change_email" id="is_change_email" value="0"/>
                                        <span class="form-text required">New Email Address </span>
                                        <input type="email" name="changeemail" class="form-control account-email-address" value="{{$user->email}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <label for="">Password</label>
                                <div class="input-wrapper">
                                    <button class="change-pw">change password</button>
                                    <div class="hid change-pwd">
                                        <input type="hidden" name="is_change_pwd" id="is_change_pwd" />
                                        <span class="form-text required">Old Password </span>
                                        <input type="password" name="oldpw" class="form-control pwd-required">
                                        <span class="form-text required " >New Password </span>
                                        <input type="password" name="newpwd" class="form-control pwd-required listen-on-keyup account-password " data-act="account_validate_password_field">
                                        <span class="form-text required">Confirm Password </span>
                                        <input type="password" name="confirm-pwd" class="form-control pwd-required">

                                        <div class="div-password-strength"></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.account-details -->

                    <div class="col-xl-6 authentication">
                        <!-- account -->
                    </div><!-- /.authentication -->
                </div>

                <div class="row" style="margin-top:30px">
                    <div class="col-xl-6"  >
                        <div  >
                            <div class="d-flex align-items-center justify-content-end">
                                <button type="button" class="btn btn-primary btn-save btn-with-act btn-account-update"  data-act="save_account_updates">
                                    Save
                                </button>
                                <button type="submit" id="btn-hidden-submit" style="opacity:0;visibility:hidden">Submit</button>
                            </div>

                        </div>

                        <div class="div-account-update-msg" style="margin-top:20px"></div>
                    </div>

                </div>
            </form><!-- #frm-account-update -->
        </div><!-- /.m-portlet__body -->
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr('#birthday',{
        dateFormat: "d-m-Y",
        disableMobile: "true"
    })
</script>
@endsection
