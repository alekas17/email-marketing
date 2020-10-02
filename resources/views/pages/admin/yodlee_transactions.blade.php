@extends('layouts.main')

@section("styles_and_js")
<style type="text/css">
#m_header_menu #logo{
    background:none;
}
.my-card.top-my-card{
    display:none !important;
}
</style>
@endsection

@section("main_content")


@section("subheader")


<div class="m-subheader ">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-xl-9 col-lg-12">
            <div class=" invisible" style="height:63.7px;">
            </div>
        </div>
    </div>
</div>
@endsection
<!--Begin::Section-->
<div class="container-fluid ">
    <div class="m-portlet m-portlet--full-height my-account">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Transactions - {{ucwords($user->email)}}
                    </h3>
                    <form id="frm_admin_yodlee_transactions" style="width:300px; float:right; position:relative">

                        <div class="row">
                            <div class="col-10">
                                <input type="text" name="keyword" class="form-control " placeholder="Search ... "/>
                                <input type="hidden" name="page" class="admin_yodlee_transactions_list_page" value="0" />
                                <input type="hidden" name="user_id" value="{{$user->id}}"/>
                                <button
                                    type="button"
                                    class="btn btn-link btn-with-act"
                                    style="position:absolute;right: 20px;top: 7px;"
                                    onclick="getYodleeTransactions()"
                                >
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>

                            <div class="col-2">
                                <button
                                    type="button"
                                    class="btn btn-link btn-with-act"
                                    style="position:absolute;right: 11px;top: 7px;"
                                    onclick="getYodleeTransactions()"
                                >
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="m-portlet__body" style="opacity: 1;">
            <table class="table table-bordered table-striped">
                <thead>
                    <th></th>
                    <th>Merchant Name</th>
                    <th>Transaction ID</th>
                    <th>Account ID</th>
                    <th>Amount</th>
                    <th>Currency</th>
                    <th>Base Type</th>
                </thead>
                <tbody id="transactions-table-body">
                    <tr>
                        <td colspan="15" class="text-center"> Loading... </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section("footer")
<script>
    function getYodleeTransactions() {
        let url = "{{ route('api.admin.user.transactions') }}"

        let transactions_table_body = $('#transactions-table-body')

        $.ajax({
            url: url,
            type: "GET",
            dataType: "json",
            data: $("#frm_admin_yodlee_transactions").serialize(),
            headers: {
                "X-CSRF-Token": $('meta[name="_token"]').attr("content")
            },
            beforeSend: function() {
                transactions_table_body.html(
                    `<tr>
                        <td colspan="15" class="text-center"> Loading... </td>
                    </tr>`
                )

            },
            success: function(response) {
                let transactions = response.transactions

                let transactions_table_body_html = ""
                if(!transactions.length) {
                    transactions_table_body_html =
                    `<tr>
                        <td colspan="15" class="text-center">
                            No transaction.
                        </td>
                    </tr>
                    `
                }else{
                    transactions_table_body_html = ""

                    for(let i = 0; i < transactions.length; i++) {
                        let transaction = transactions[i]

                        transactions_table_body_html += `
                            <tr>
                                <td>${transaction.transaction_date}</td>
                                <td>${transaction.merchant_name}</td>
                                <td>${transaction.transaction_id}</td>
                                <td>${transaction.account_id}</td>
                                <td>${transaction.amount}</td>
                                <td>${transaction.currency}</td>
                                <td>${transaction.base_type}</td>
                            </tr>
                        `
                    }
                }

                transactions_table_body.html(transactions_table_body_html)
            },
            error: function(error) {
                console.log('error', error.transactions)
            }
        });
    }

    $(document).ready(function() {
        getYodleeTransactions()

        $('#frm_admin_yodlee_transactions').submit(function(event) {
            event.preventDefault();
        })
    })
</script>
@endsection
