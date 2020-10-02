<div id="admin-user-table-message">
</div>


@if($users_list->count() > 0 )

    <table class="table table-bordered table-striped">
        <thead>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th class="text-center">Bank Account</th>
            <th style="width:450px"></th>
        </thead>
        <tbody>
            @foreach($users_list->items() as $user)
                <tr id="admin-user-table-th-{{ $user->id }}" class="">
                    <td id="admin-user-table-name-{{ $user->id }}">
                        {{$user->name}} {{$user->last_name}}
                    </td>
                    <td id="admin-user-table-email-{{ $user->id }}">
                        {{$user->email}}
                    </td>
                    <td id="admin-user-table-phone-{{ $user->id }}">
                        {{$user->phone}}
                    </td>
                    <td class="text-center" id="has-bank-account-{{ $user->id }}">
                       Loading...
                    </td>
                    <td style="text-align:center">
                        <button
                            type="button"
                            class="btn btn-primary btn-with-act"
                            id="edit-info-btn-{{ $user->id }}"
                            onclick="showUpdateUserModal({{$user}})"
                        >
                            <i class="fa fa-pencil"></i> Edit Info
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary btn-with-act"
                            id="delete-user-btn-{{ $user->id }}"
                            onclick="deleteUser({{$user}})"
                        >
                            <i class="fa fa-trash"></i> Delete
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary btn-with-act"
                            data-act="update_user_password_modal"
                            data-userid="{{$user->id}}"
                        >
                            <i class="fa fa-key"></i> Change Password
                        </button>
                        <a
                            title="Yodlee transactions"
                            href="{{url('/administrator/yodlee_transactions/'.$user->id)}}"
                            class="btn btn-primary "
                        >
                            <i class="fa fa-list"></i> Yodlee
                        </a>
                    </td>
                </tr>

                <script>
                    $(document).ready(function() {
                        setTimeout(function(){
                            $.ajax({
                                url: "{{ url('api/admin/user/user/account?user_id=' . $user->id) }}",
                                type: 'get',
                                headers: {
                                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                                },
                                beforeSend: function () {
                                    $('#has-bank-account-{{ $user->id }}').html('Loading...')
                                },
                                success: function (response) {
                                    let result_html = '<i class="text-success fa fa-check"></i>'

                                    if(response.bank_accounts_count < 0) {
                                        result_html = '<i class="text-danger fa fa-times"></i>'
                                    }

                                    $('#has-bank-account-{{ $user->id }}').html(result_html)
                                },
                                error: function (error) {
                                    let result_html = '<i class="text-danger fa fa-times"></i>'
                                    $('#has-bank-account-{{ $user->id }}').html(result_html)
                                },
                            });
                        }, 1000);
                    });

                </script>
            @endforeach
        </tbody>
    </table>

    <div style="padding:10px 0px">
        {{$users_list->links("vendor.pagination.bootstrap-4",["act"=>"admin_users_list_paging"])}}
    </div>

    @include('pages.admin.update-user-modal')
@endif
