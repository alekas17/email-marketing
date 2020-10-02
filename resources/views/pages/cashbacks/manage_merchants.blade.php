<div class="manage-merchants">
    <form class="" style="margin-bottom:20px">
        <div class="row">
            <div class="col-xl-3">
                <input type="text" class="form-control input-merchant-name" placeholder="Enter merchant name ..."/>
            </div>

            <div class="col-xl-3">
                <input type="text" class="form-control input-merchant-id" placeholder="Enter merchant ID ..."/>
            </div>

            <div class="col-xl-2" style="position:relative">
                <input min="0" max="100" type="text" class="form-control input-merchant-percentage" placeholder="Percent"/>
                <span style="position:absolute; right:25px; top:5px;">%</span>
            </div>

            <div class="col-xl-3" style="position:relative">
                <input min="0" max="100" type="text" class="form-control input-merchant-fee-percentage" placeholder="Fee Percentage"/>
                <span style="position:absolute; right:25px; top:5px;">%</span>
            </div>

        

            <div class="col-xl-1">
                <button type="button" class="btn btn-primary btn-with-act" data-act="admin_manage_merchant_add_new">Save</button>
            </div>
        </div>
 

    </form>
    <table class="table table-striped table-bordered">
        <thead>
            <th style="width:150px">Merchant</th>
            <th>Merhcant ID </th>
            <th>Percent</th>
            <th>Fee Percentage</th>
            <th style="width:20%">Linked User</th>
            <th style="width:150px"></th>
        </thead>
        <tbody>
            @if(!empty($merchants)) 
                @foreach($merchants as $merchant)
                <tr class="tr-{{$merchant->id}}">
                    <td>
                        <div class="merchant-field-toggle">{{$merchant->name}}</div>
                        <div class="hide merchant-field-toggle"><input type="text" class="form-control input-merchant-name-{{$merchant->id}}" value="{{$merchant->name}}"/></div>
                    </td>
                    <td>
                        <div class="merchant-field-toggle">{{$merchant->merchant_id}}</div>
                        <div class="hide merchant-field-toggle"><input type="text" class="form-control input-merchant-id-{{$merchant->id}}" value="{{$merchant->merchant_id}}"/></div>
                    </td>
                    <td>
                        <div class="merchant-field-toggle">{{ number_format( ($merchant->cashback_percent * 100), 2 ) }}%</div>
                        <div class="hide merchant-field-toggle" style="position:relative">
                            <input type="number" min="0" max="100" class="form-control input-merchant-percentage-{{$merchant->id}}" value="{{($merchant->cashback_percent * 100) }}"/>
                            <span style="position:absolute; right:10px; top:5px;">%</span>
                        </div>
                    </td>
                    <td>
                        <div class="merchant-field-toggle">{{ number_format( ($merchant->fee_percentage * 100), 2 ) }}%</div>
                        <div class="hide merchant-field-toggle" style="position:relative">
                            <input type="number" min="0" max="100" class="form-control input-merchant-feepercentage-{{$merchant->id}}" value="{{($merchant->fee_percentage * 100) }}"/>
                            <span style="position:absolute; right:10px; top:5px;">%</span>
                        </div>
                    </td>
                    <td >
                        <div class="merchant-field-toggle">
                            @if(!empty($merchant->user))
                            {{ $merchant->user->email }}
                            @endif
                        </div>
                        <div class="hide merchant-field-toggle div-user-link-{{$merchant->id}}" style="position:relative">
                            <select class="with-select-2 listen-on-change linked-user-merchant-{{$merchant->id}}"  style="width:100%">
                                <option value=""></option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                    @if(!empty($merchant->user))
                                        @if($merchant->user->id == $user->id) {{"selected"}} @endif
                                    @endif;
                                    >{{$user->email}}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td style="text-align:center">
                        <div class="merchant-field-toggle">
                            <button data-id="{{$merchant->id}}" type="button" class="btn btn-primary btn-sm btn-with-act" data-act="admin_manage_merchant_offers"><i class="fa fa-tags" style="font-size:12px"></i></button>
                            <button data-id="{{$merchant->id}}" type="button" class="btn btn-primary btn-sm btn-with-act" data-act="admin_manage_merchant_edit"><i class="fa fa-edit" style="font-size:12px"></i></button>
                            <button data-id="{{$merchant->id}}" type="button" class="btn btn-primary btn-sm btn-with-act btn-danger" data-act="admin_manage_merchant_delete"><i class="fa fa-times" style="font-size:12px"></i></button>
                        </div>
                        <div class="hide merchant-field-toggle" style="position:relative">
                            <button type="button" class="btn btn-primary btn-sm btn-with-act" data-act="admin_manage_merchant_save_edit" data-id="{{$merchant->id}}">Save</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>