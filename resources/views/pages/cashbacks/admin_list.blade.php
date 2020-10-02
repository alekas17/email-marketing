@if( $cashback_list->total() > 0 )
    <table class="m-datatable__table payments-datatable">
        <thead>
            <th>Date</th>
            <th>Recipient</th>
            <th>Merchant</th>
            <th>Amount</th>
            <th style="width:120px"></th>
        </thead>
        <tbody>
        @foreach($cashback_list->items() as $list)

            <tr>
                <td>{{\Carbon\Carbon::parse($list->transaction_date)->format("d/m/Y")}}</td>
                <td>{{$list->recipient}}</td>
                <td>{{$list->merchant_name}}</td>
                <td>${{ number_format( $list->amount , 2 )}}</td>
                <td style="width:120px">
                    <button type="button" class="btn btn-primary btn-sm btn-with-act" data-id="{{$list->id}}" data-act="admin_edit_cashback"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-primary btn-sm btn-with-act" data-id="{{$list->id}}" data-act="admin_delete_cashback"><i class="fa fa-times"></i></button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="padding:10px 20px">{{$cashback_list->links("vendor.pagination.bootstrap-4",['act' => 'paginate_cashback_list'])}}</div>

@else

    <div class="no-payment text-center  ">
        <img src="{{url('images/payments/no-payment.png')}}" alt="">
        <h4>No records found</h4>
     </div>

@endif
