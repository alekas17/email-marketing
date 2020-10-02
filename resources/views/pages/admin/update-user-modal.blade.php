
<div id="update-user-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >
                    Update Information
                </h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                    onclick="cancelUpdateUser()"
                >
                    <i class="fa fa-times"></i>
                </button>
            </div><!-- /.modal-header -->

            <div class="modal-body">
                <div id="update-user-modal-message">
                </div>

                <form id="update-user-form">
                    <input type="hidden" name="user_id">
                    <input type="hidden" name="phone">

                    <div class="row">
                        <div class="col-6">
                            <label>Role :</label>
                            <div class="form-group">
                                <select
                                    class="form-control input-sm"
                                    name="user_type"
                                    style='
                                        font-family: "Kanit";
                                        font-size: 16px;
                                        color: #999999;
                                        font-weight: 300;
                                        border-radius: 0 !important;
                                        height: 45px;
                                        border: 1px #999999 solid;
                                    '
                                >
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                            </div>
                        </div>
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="col-6">
                            <label>First Name :</label>
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control input-sm"
                                    name="name"
                                    placeholder="First Name"
                                >
                            </div>
                        </div>

                        <div class="col-6">
                            <label>Last Name :</label>
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control "
                                    name="last_name"
                                    placeholder="Last Name"
                                >
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Email :</label>

                                <input
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    placeholder="Email"
                                >
                            </div>
                        </div>
                    </div><!-- /.row -->
                </form><!-- /form -->
            </div><!-- /.modal-body -->

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-default"
                    onclick="cancelUpdateUser()"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    id="save-update-user-btn"
                    onclick="updateUser()"
                >
                    Save
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    function showUpdateUserModal(user) {
        $('#update-user-modal').modal('show')

        let update_user_form = $('#update-user-form')

        update_user_form.find("input, textarea").val("");
        $('#update-user-modal-message').html("")

        update_user_form.find('input[name=name]').val(user.name)
        update_user_form.find('input[name=last_name]').val(user.last_name)
        update_user_form.find('input[name=email]').val(user.email)
        update_user_form.find('input[name=user_id]').val(user.id)
        update_user_form.find('input[name=phone]').val(user.phone)
        update_user_form.find('select[name=user_type]').val(user.user_type)
    }

    function cancelUpdateUser() {
        $('#update-user-modal').modal('hide')
        let update_user_form = $('#update-user-form')

        update_user_form.find("input, textarea").val("");
    }

    function updateUser() {
        let update_user_form = $('#update-user-form')
        let user_id = update_user_form.find('input[name=user_id]').val()

        let url = `{{ route('api.admin.user.update', ["id" => ":user_id"]) }}`
        url = url.replace(":user_id", user_id);

        let save_update_user_btn = $('#save-update-user-btn');

        $.ajax({
            url: url,
            type: 'PUT',
            data: update_user_form.serialize(),
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            beforeSend: function () {
                save_update_user_btn.html('Saving...').attr('disabled', true)
                update_user_form.find("input, select").attr('disabled', true)

                $('#update-user-modal-message').html("")
            },
            success: function (response) {
                console.log('update-user-ajax', response)
                save_update_user_btn.html('Save').removeAttr('disabled')
                update_user_form.find("input, select").removeAttr('disabled')
                $('#update-user-modal-message').html("")

                $('#update-user-modal').modal('hide')

                let user_response = response.user
                user_response.id = user_id

                let name  = `${user_response.name} `
                name += user_response.last_name ? user_response.last_name : ''

                $('#admin-user-table-name-' + user_id).html(name)
                $('#admin-user-table-email-' + user_id).html(user_response.email)
                $('#edit-info-btn-' + user_id).attr(
                    'onclick',
                    `showUpdateUserModal(${JSON.stringify(user_response)})`
                )
                $('#delete-user-btn-' + user_id).attr(
                    'onclick',
                    `deleteUser(${JSON.stringify(user_response)})`
                )

                setTimeout(function(){
                    alert(response.message)
                }, 500);

            },
            error: function (error) {
                let json_response = error.responseJSON
                let alert_html = `<div class="alert alert-danger" role="alert">
                    <div class="alert-text">
                        ${json_response.message}
                    </div>
                </div>`

                $('#update-user-modal-message').html(alert_html)

                save_update_user_btn.html('Save').removeAttr('disabled')
                update_user_form.find("input, select").removeAttr('disabled')
            },
        });
    }

    function deleteUser(user) {
        let email = user.email
        let user_id = user.id

        if(!user_id) {
            alert('Invalid User!')
            return false
        }

        let message = `Are you sure you want to delete ${email}?`
        if (confirm(message)) {
            // ajax
            let url = `{{ route('api.admin.user.delete', ["id" => ":user_id"]) }}`
            url = url.replace(":user_id", user_id);

            let delete_user_btn = $('#delete-user-btn-' + user_id)

            $.ajax({
                url: url,
                type: 'DELETE',
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                beforeSend: function () {
                    delete_user_btn.html('Deleting...').attr('disabled', true)
                    $('#admin-user-table-th-' + user_id).addClass("table-danger")
                },
                success: function (response) {
                    delete_user_btn.html('<i class="fa fa-trash"></i> Delete')
                    delete_user_btn.attr('disabled', false)

                    $('#admin-user-table-th-' + user_id).remove()

                    let alert_html = `<div class="alert alert-success" role="alert">
                        <div class="alert-text">
                            ${response.message}
                        </div>
                    </div>`

                    $('#admin-user-table-message').html(alert_html)
                },
                error: function (error) {
                    let json_response = error.responseJSON
                    let alert_html = `<div class="alert alert-danger" role="alert">
                        <div class="alert-text">
                            ${json_response.message}
                        </div>
                    </div>`

                    $('#admin-user-table-message').html(alert_html)
                    $('#admin-user-table-th-' + user_id).removeClass("table-danger")

                    delete_user_btn.html('<i class="fa fa-trash"></i> Delete')
                    delete_user_btn.attr('disabled', false)
                },
            });
            // end ajax
        }
    }
</script>
