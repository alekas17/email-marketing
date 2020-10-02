@if( $cashback_list->total() > 0 )
    <table class="m-datatable__table payments-datatable">
        <thead>
            <th>Date</th>
            <th>Merchant</th>
            <th>Amount</th>
        </thead>
        <tbody>
        @foreach($cashback_list->items() as $list)

            <tr>
                <td>{{date("d/m/Y",strtotime($list->transaction_date))}}</td>
                <td>{{$list->merchant_name}}</td>
                <td>${{ number_format( $list->amount , 2 )}}</td>
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
