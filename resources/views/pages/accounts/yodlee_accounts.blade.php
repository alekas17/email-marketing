@if(!$accounts["error"])
    @if(!empty($accounts["accounts_list"]))
        @if(!empty($accounts["accounts_list"]->account))
            <h4>Accounts List</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <th>Institution</th>
                    <th>Account</th>
                </thead>
                <tbody>
                @foreach($accounts["accounts_list"]->account as $account)
                    <tr>
                        <td>{{$account->providerName}}</td>
                        <td>{{$account->accountName}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">No accounts found</div>
        @endif
    @else
        <div class="alert alert-info">No accounts found</div>
    @endif
@else
    <div class="alert alert-info">No accounts found</div>
@endif
