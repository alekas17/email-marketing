@if( $payments_list->total() > 0 )
    <table class="table table-bordered table-striped">
        <thead>
            <th>submitted</th>
            <th>recipient</th>
            <th>payment reference</th>
            <th>status</th>
            <th>payment</th>
            <th nowrap>transaction reference</th>
        </thead>
        <tbody>
        @foreach($payments_list->items() as $list)
            
            <tr>
                <td>{{date("d/m/Y",strtotime($list->scheduled_date))}}</td>
                <td>{{$list->business_name}}</td>
                <td class="blue">{{$list->receipt_number}}</td>

                @php 
                switch($list->status){
                    case 0: $class = "gray"; break;
                    case 1: $class = "green";  break;
                    case 2: $class = "Cancelled";  break;
                    case 3: $class = "red";  break;
                    case 4: $class = "blue";  break;
                }
                @endphp

                <td class="{{$class}}">
                    @php 
                    switch($list->status){
                        case 0: echo "In Progress"; break;
                        case 1: echo "Completed";  break;
                        case 2: echo "Cancelled";  break;
                        case 3: echo "Declined";  break;
                        case 4: echo "Pending";  break;
                    }
                    @endphp
                </td>
                <td>${{ number_format( ( $list->amount + $list->service_fee + $list->gst ) / 100 , 2 )}}</td>
                <td>{{$list->payment_reference}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="padding:10px 20px">{{$payments_list->links("vendor.pagination.bootstrap-4",["act"=>"admin_user_transactions_list"])}}</div>

@else

    

@endif