<div class="m-form__group form-group row">
    <label class="col-6 col-form-label">All</label>
    <div class="col-6 text-right">
        <span class="m-switch">
            <label>
            <input type="checkbox" name="" class="listen-on-change" data-act="ck_pay_status_all">
            <span></span>
            </label>
        </span>
    </div>
</div>
<!-- form-group -->
@foreach($statuses as $k=>$status)
    <div class="m-form__group form-group row">
        <label class="col-6 col-form-label">{{$status}} ({{$payment_status[$k]}})</label>
        <div class="col-6 text-right">
            <span class="m-switch">
                <label>
                <input type="checkbox" name="payment_status[]" value="{{$k}}" class="ck-sidebar-payment-status listen-on-change" data-act="reload_cashback_list">
                <span></span>
                </label>
            </span>
        </div>
    </div>
@endforeach
