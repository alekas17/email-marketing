<form id="frm-update-user-password">
    <input type="hidden" name="user_id" value="{{$user_id}}" />
    <input type="hidden" class="hdn-user-email" value="{{$user->email}}"/>

    <input type="password" class="form-control new-password listen-on-keyup" data-act="admin_validate_password_change" name="password" placeholder="Enter password here"/>
    <div class="div-password-strength"></div>

    <button type="button" class="btn btn-primary btn-admin-update-password btn-with-act" data-act="admin_update_user_password"  disabled>Update Password</button>

</form>