@if( !empty($basiq_accounts_list)) 

    <table class="table table-bordered table-striped">
        <thead>
            <th style="width:50px"></th>
            <th>Name</th>
        </thead>
        <tbody>
        @foreach($basiq_accounts_list as $list)
        
            <tr>
                <td><i class="fa fa-check"></i></td>
                <td>{{$list}}</td>
          
            </tr>
        @endforeach
        </tbody>
    </table>


@else

    <div class="alert alert-info" style="font-size:15px">No records found</div>

@endif