@extends('layouts.main', ["is_cashback" => 1])
@section("main_content")


@section("subheader")
<style type="text/css">
.manage-payments .filter-all .filter-box > .search {
    margin-bottom: 20px;
    font-family: "Kanit";
    border: 1px solid #999999;
    font-size: 15px;
    color: #999999;
    height: 48px;
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
    background: url(../images/payments/dropdown-arrow.png) no-repeat 95% center;
}
.top-default-card-details{
    display:none;
}
@media only screen and (max-width:1024px) {
    .m-body .m-content {
        padding:0;
    }
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
 <div class="container-fluid manage-payments">
     <div class="row">
       
        <div class="col-xl-12 form-container payments-list">
            <form action="#" onsubmit="return false;">

                @csrf
                    <!--begin:: Widgets/Best Sellers-->
                    <div class="m-portlet m-portlet--full-height ">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Manage Cashbacks
                                    </h3>
                                    <div class="make-a-payment">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body cashback-list-container">

                            
                        </div>
                    </div>
            </form>
          
            <!--end:: Widgets/Authors Profit-->
        </div>   
    </div>
</div>

@endsection
