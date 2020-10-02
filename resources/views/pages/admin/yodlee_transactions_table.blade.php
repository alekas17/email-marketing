@if( $transactions->total() > 0 )

    <table class="table table-bordered table-striped">
        <thead>
            <th></th>
            <th>Merchant Name</th>
            <th>Transaction ID</th>
            <th>AccountID</th>
            <th>Amount</th>
            <th>Currency</th>
            <th>BaseType</th>
        </thead>
        <tbody>
        @foreach($transactions->items() as $list)
        
            <tr>
                <td>
                    {{date("d/m/Y", strtotime($list->transaction_date))}}
                </td>
                <td>{{$list->merchant_name}}</td>
                <td>{{$list->transaction_id}}</td>
                <td>{{$list->account_id}}</td>
                <Td>
                    {{$list->amount}}
                </Td>
                <td>{{$list->currency}}</td>
                <td>{{$list->base_type}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="padding:10px 20px">{{$transactions->links("vendor.pagination.bootstrap-4",["act"=>"admin_yodlee_transactions_list"])}}</div>

@else

    <div class="alert alert-info" style="font-size:15px">No records found</div>

@endif