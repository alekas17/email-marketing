@extends('layouts.main')
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
.form-control-feedback{
    color:#b8132c;
    margin-top:5px;
}
.btn-search-cashback{
    position:absolute !important;
    background: none !important;
    border: none !important;
    color: #8a8a8a !important;
    padding: 0px !important;
    width: 37px !important;
    top: -7px !important;
    right: 13px !important;
}
.btn-search-cashback:hover{
    color: #333 !important;
}
.btn-search-cashback:before{
    margin:0px !important;
    background:none !important;
}
.btn-add-merchant:before{
    margin:0px !important;
    content:"" !important;
}
.manage-merchants .hide,
.manage-offers .hide{
    display:none;
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
            <form action="#" onsubmit="return false;" class="cashback-list-filter">
                <!--begin:: Widgets/Best Sellers-->
                <div class="m-portlet m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Manage Cashbacks
                                </h3>
                                <div class="make-a-payment">
                                    <div class="row">
                                        <div class="col-xs-3"> </div>
                                        <div class="col-xs-3">
                                            <input type="hidden" name="page" class="payment_list_page" value="0"/>
                                            <input type="hidden" name="is_admin" value="1"/>
                                            <div class="filter-box" style="position:relative;margin-top: 8px;margin-right: 20px;">
                                                <input style="width:200px" type="text" class="form-control m-input search listen-on-change" name="search_key" data-act="cashback_search_list" placeholder="Search recipient... "/>
                                                <button type="button" class="btn btn-primary btn-link btn-search-cashback" style="position:absolute;"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-xs-3">
                                            <button type="button" data-id="0" class="btn-with-act" data-act="admin_add_cashback" >Add Cashback</button>
                                        </div>
                                        <div class="col-xs-3" style="padding-left:10px">
                                            <button type="button" data-id="0" class="btn-with-act btn-add-merchant" data-act="admin_add_merchant" ><i class="fa fa-plus" style="margin-right:10px"></i> Add Merchant</button>
                                        </div>
                                    </div>
                                    
                                    

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body cashback-list-container" data-isadmin="0">

                        
                    </div>
                </div>
            </form>
          
            <!--end:: Widgets/Authors Profit-->
        </div>   
    </div>
</div>



<div class="modal" tabindex="-1" role="dialog" id="div-add-cashback-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Cashback</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>             
        </div>
    </div>
</div>

<div class="modal" role="dialog" id="div-add-merchant-modal">
    <div class="modal-dialog modal-lg" role="document" style="max-width:80%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Merchant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="text-align:center; padding:30px; font-size:13px;"><i class="fa fa-spin fa-spinner"></i></div>
            </div>             
        </div>
    </div>
</div>



@endsection
