@if(empty($rsession))
    @if(!empty($JSONcallBackStatus))
        <script type="text/javascript">
            window.parent.Plastiq.BankDetails.redirecToBankDetailsPage();
        </script>
    @else
        <div style="padding:20px; text-align:center">Loading fastlink</div>
    @endif
@else

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>

    <form action="{{env("YODLEE_NODE_URL")}}"
    method="POST">
    <input type="hidden" name="app" value="{{env("YODLEE_APP_ID")}}" />
    <input type="hidden" name="rsession" value="{{$rsession}}" />
    <input type="hidden" name="token" value="{{$token}}" />
    <input type="hidden" name="redirectReq" value="true" />
    <input type="hidden" name="extraParams" value="callback={{url("yodlee_iframe")}}?close=true" />
    <input type="submit" style="opacity:0; visibility:hidden" name="submit" class="btn btn-primary btn-submit-yodlee-form"/>
    </form>

    <script type="text/javascript">
    $(document).ready(function(){
        setTimeout(function(){
            $(".btn-submit-yodlee-form").trigger("click");
        }, 100);
    });


    </script>
@endif
