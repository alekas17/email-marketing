@extends('layouts.main')

@section("styles_and_js")
<style type="text/css">
#m_header_menu #logo{
    background:none;
}
.my-card.top-my-card{
    display:none !important;
}
</style>
@endsection

@section("main_content")

@section("subheader")
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
    <div class="m-portlet m-portlet--full-height my-account">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Admin - Users List
                    </h3>

                    <form id="frm_admin_users_list" style="width:300px; float:right; position:relative">
                        <input type="text" name="search_key" class="form-control " placeholder="Search name, email or phone "/>
                        <input type="hidden" name="page" class="admin_users_list_page" value="0" />
                        <button type="button" class="btn btn-link btn-with-act" data-act="admin_search_users" style="position:absolute;right: 11px;top: 7px;"><i class="fa fa-search"></i></button>
                    </form>
                    
                </div>
            </div>
        </div>
        <div class="m-portlet__body" style="opacity: 1;">
            
            <div class="div-admin-users-list"> </div>

        </div>
    </div>

</div>


<!-- update password -->
<div class="modal fade" id="update-password-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update <span class="pwd-user-email"></span> Password </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      </div>
      
    </div>
  </div>
</div>
<!-- update password -->

@endsection
