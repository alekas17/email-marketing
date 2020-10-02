<form id="frm-cashback" action="{{route($route, $id)}}" method={{$method}}>
    <div class="form-group">
        <label >Date</label>
        <input
            type="text"
            name="transaction_date"
            value="@if(!empty($cashback)){{date('m/d/Y',strtotime($cashback->transaction_date))}}@endif"
            class="form-control with-datepicker"
            required
        />
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Merchant</label>
        <select class="with-select2 form-control" name="merchant_id" required>
            <option></option>
            @if(!empty($merchants))
                @foreach($merchants as $merchant)
                <option value="{{$merchant->id}}"
                    @if(!empty($cashback))
                        @if($merchant->id==$cashback->merchant_id)
                            {{"selected"}}
                        @endif
                    @endif>{{$merchant->name}}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Recipient</label>
        <select class="with-select2 form-control" name="user_id" required>
            <option></option>
            @if(!empty($users))
                @foreach($users as $user)
                <option value="{{$user->id}}"
                    @if(!empty($cashback))
                        @if($user->id==$cashback->user_id)
                            {{"selected"}}
                        @endif
                    @endif
                    >{{$user->email}}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Amount</label>
        <input type="number" value="@if(!empty($cashback)){{$cashback->amount}}@endif" name="amount" class="form-control" required/>
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Transaction ID</label>
        <input type="decimal" value="@if(!empty($cashback)){{$cashback->basiq_transaction_id}}@endif" name="basiq_transaction_id" class="form-control"/>
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Status</label>
        <input type="text" value="@if(!empty($cashback)){{$cashback->status}}@endif" name="status" class="form-control"/>
    </div>

    <div class="form-group">
        <button type="button" class="btn btn-primary btn-with-act" data-act="save_cashback">Save</button>
        <button type="submit" class="btn-submit-cashback" style="visibility: hidden; opacity:0"></button>
    </div>

</form>
