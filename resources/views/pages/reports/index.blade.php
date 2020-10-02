@extends('layouts.main')
@section("main_content")
@section("subheader")
@php $report = true;  @endphp
<style type="text/css">
.manage-payments .filter-all .filter-box > .search {
    margin-bottom: 20px;
    font-family: "Kanit";
    border: 1px solid #999999;
    font-size: 15px;
    color: #999999;
    height: 48px;
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
    background: url(../images/payments/dropdown-arrow.png) no-repeat 95% center;
}
.top-default-card-details{
    display:none;
}

@media only screen and (max-width:1024px) {
    .m-body .m-content {
        padding:0;
    }
}

.m-portlet .m-portlet__body {
  padding: 2.2rem 2.2rem;
}

#merchant-reporting .sales .m-widget-18 {
    display: flex;
      padding-bottom: 50px;
  border-bottom: 1px solid #e1e1e1;
  margin-bottom: 50px;
}
.m-widget-18__summary {
  width: 20%;
  text-align: center;
}
.m-widget-18__progress {
    width: calc(80% - 43px);
    margin-left: 43px;
}

.m-widget-18__label {
  font-family: "Kanit";
  font-size: 18px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: normal;
  letter-spacing: normal;
  color: #4c4c4c;
  white-space: nowrap;
}

.m-widget-18__total{
  font-family: "Kanit";
  font-size: 32px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: 1;
  letter-spacing: normal;
  text-align: center;
  color: #4c4c4c;
}
.locations {
    width: 100%;
    display: flex;
}

.locations .location{
    display: flex;
    flex-direction: column;
    text-align: center;
}
.locations .location h4 {
  font-family: "Kanit";
  font-size: 18px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: normal;
  letter-spacing: normal;
  text-align: center;
  color: #4c4c4c;
  margin: 0;
  white-space: nowrap;
}

.locations .location span {
  font-family: "Kanit";
  font-size: 20px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: normal;
  letter-spacing: normal;
  text-align: center;
  margin-bottom: 5px;
}
.m-widget-18_percent {visibility: hidden;}
.filter-options .col-form-label  {
  font-family: Kanit;
  font-size: 18px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  letter-spacing: normal;
  text-align: left;
  color: #4c4c4c;
  margin-bottom: 18px;

}

.filter-options select  {
  font-family: Kanit;
  font-size: 16px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: 5;
  letter-spacing: normal;
  text-align: left;
  color: #4c4c4c;
   border-radius: 2px;
   height: 44px;
  border: solid 1px #dedee7;
  background-color: #f3f3fa
}

.filter-results h2{
  font-family: Kanit;
  font-size: 24px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: 1;
  letter-spacing: normal;
  text-align: center;
  color: #4c4c4c;
  margin: 55px auto 40px;
}
.total-users .m-widget27__legends {
    margin-top: 60px;
}
.total-users .m-widget27__legend {
    display: flex;
    justify-content: space-between;
}
.total-users .m-widget27__legend-text, 
.total-users .count {
  font-family: Kanit;
  font-size: 18px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: normal;
  letter-spacing: normal;
  text-align: left;
  color: #4c4c4c;
}
.total-users .purple .count {
    color: #6f6ab0;
}
.total-users .m-widget27__legend > div {
    display: flex;
    align-items: center;
}
.total-users .aquagreen .count {
    color: #2ebca2;
}
.total-users .m-widget27__legend-bullet {
  width: 22px;
  height: 6px;
  border-radius: 3px;
  margin-right: 15px;
}
.total-users .purple .m-widget27__legend-bullet {
    background-color: #6f6ab0;
}
.total-users .aquagreen .m-widget27__legend-bullet {
    background-color: #2ebca2;
}
.offer-redemption .cashback select{
  font-family: "Kanit";
  font-size: 16px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: 5;
  letter-spacing: normal;
  text-align: left;
  color: #4c4c4c;
  border-radius: 2px;
  height: 44px;
  border: solid 1px #dedee7;
  background-color: #f3f3fa;
}

.offer-redemption .cashback .customer {
    margin-top: 50px;
}
.offer-redemption .cashback .customer > div{
    display: flex;
    justify-content: space-between;
  font-family: "Kanit";
  font-size: 18px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: normal;
  letter-spacing: normal;
  text-align: left;
  color: #4c4c4c;
}

.offer-redemption .cashback .customer span  {
  font-family: "Kanit";
  font-size: 18px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: normal;
  letter-spacing: normal;
  text-align: right;
}
.offer-redemption .cashback .customer span.purple {
  color: #6f6ab0;
}
.offer-redemption .cashback .customer span.yellow {
  color: #fdb722;
}
.offer-redemption .m-widget27__legends {
    margin-top: 90px;
}
.offer-redemption .m-widget27__legends .m-widget27__legend-text {
  font-family: Kanit;
  font-size: 18px;
  font-weight: normal;
  font-style: normal;
  font-stretch: normal;
  line-height: normal;
  letter-spacing: normal;
  text-align: left;
  color: #4c4c4c;
}
.offer-redemption .m-widget27__legend-bullet {
  width: 22px;
  height: 6px;
  border-radius: 3px;
  margin-right: 15px;
}
.offer-redemption .purple .m-widget27__legend-bullet {
    background-color: #6f6ab0;
}
.offer-redemption .yellow .m-widget27__legend-bullet {
    background-color: #fdb722;
}
.offer-redemption .m-widget27__legend {
    display: flex;
    align-items: center;
}
</style>
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
<div class="container-fluid " id="merchant-reporting">
    <div class="row">
        <div class="col-xl-5 col-lg-12">
            <!--Begin::Portlet-->
            <div class="m-portlet  m-portlet--full-height sales" style="background:#fff;border:1px solid #e1e1e1;border-radius:8px;">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                            Sales
                            </h3>
                        </div>
                    </div>
                    
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget-18">
                        <div class="m-widget-18__summary">
                            <div class="m-widget-18__label">Net Sales YTD</div>
                            <div class="m-widget-18_percent">1%</div>
                            <div class="m-widget-18__total">$2.63m</div>
                        </div>
                        <div class="m-widget-18__progress">
                            <div class="locations">
                                <div class="location" style="width:51%; color:#ffb822;margin-left: -50px;">
                                    <h4>Location 1</h4>
                                    <span>51%</span>
                                </div>
                                <div class="location" style="width:22%; color:#34bfa3">
                                    <h4>Location 2</h4>
                                    <span>22%</span>
                                </div>
                                <div class="location" style="width:27%; color:#716aca;margin-left: 50px;">
                                    <h4>Location 3</h4>
                                    <span>27%</span>
                                </div>
                            </div>
                            <div class="progress" style="margin-top:auto;">
                                <div class="progress-bar " role="progressbar" style="width: 51%;background-color:#ffb822" aria-valuenow="51" aria-valuemin="0" aria-valuemax="100">
                                </div>
                                <div class="progress-bar" role="progressbar" style="width: 22%; background-color:#34bfa3" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100">
                                </div>
                                <div class="progress-bar" role="progressbar" style="width: 27%; background-color:#716aca" aria-valuenow="27" aria-valuemin="0" aria-valuemax="100">
                                </div>                                
                            </div>
                        </div>
                    </div>
                    {{-- // m-widget-18 --}}

                    <div class="filter-options">
                        <div class="row">
                        <div class="col-sm-4">
                            <label class="col-form-label">Year</label>
                            <div>
                                <select name="" id="" class="form-control">
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label">State</label>
                            <div>
                                <select name="" id="" class="form-control">
                                    <option value="Queensland">Queensland</option>
                                    <option value="Queensland">Queensland</option>
                                    <option value="Queensland">Queensland</option>
                                    <option value="Queensland">Queensland</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label">Demographic</label>
                            <div>
                                <select name="" id="" class="form-control">
                                    <option value="Female 18-30">Female 18-30</option>
                                    <option value="Female 18-30">Female 18-30</option>
                                    <option value="Female 18-30">Female 18-30</option>
                                    <option value="Female 18-30">Female 18-30</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    {{-- // filter-options --}}
                    <div class="filter-results">
                        <h2>Female 18-30 Queensland</h2>
                        <div class="graph">
                             <div id="m_flotcharts_5" style="height: 300px;"></div>  
                        </div>
                    </div>
                </div>
            </div>
            <!--End::Portlet-->
        </div>
        <div class="col-xl-7 ">
            <div class="row">
                <div class="col-xl-7">
                    <!--Begin::Portlet-->
                    <div class="m-portlet  m-portlet--full-height " style="background:#fff;border:1px solid #e1e1e1;border-radius:8px;">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                    Wallet Share
                                    </h3>
                                </div>
                            </div>
                            
                        </div>
                        <div class="m-portlet__body">
                           <div id="m_flotcharts_7" style="height:300px;"></div>
                        </div>
                    </div>
                    <!--End::Portlet Wallet Share-->
                </div>
                <div class="col-xl-5">
                    <!--Begin::Portlet-->
                    <div class="m-portlet  m-portlet--full-height total-users " style="background:#fff;border:1px solid #e1e1e1;border-radius:8px;">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                    Total Users
                                    </h3>
                                </div>
                            </div>
                            
                        </div>
                        <div class="m-portlet__body">
                           <div class="row  align-items-center">
                                <div class="col-12">
                                    <div id="m_chart_123" class="m-widget27__chart" style="height: 160px">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="m-widget27__legends">
                                        <div class="m-widget27__legend purple">
                                            <div>                                                
                                                <span class="m-widget27__legend-bullet purple"></span>
                                                <span class="m-widget27__legend-text">New Customer</span>
                                            </div>
                                            <span class="count">25</span>
                                        </div>
                                        <div class="m-widget27__legend aquagreen">
                                            <div>                                                
                                                <span class="m-widget27__legend-bullet yellow"></span>
                                                <span class="m-widget27__legend-text">Existing Customer</span>
                                            </div>
                                            <span class="count">42</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End::Portlet Total users-->
                </div>
                <div class="col-xl-12">
                    <!--Begin::Portlet-->
                    <div class="m-portlet  m-portlet--full-height offer-redemption" style="background:#fff;border:1px solid #e1e1e1;border-radius:8px;">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                    Offer Redemption
                                    </h3>
                                </div>
                            </div>
                            
                        </div>
                        <div class="m-portlet__body">
                           <div class="row  align-items-center" style="margin-bottom:30px;">
                                <div class="col cashback">
                                    <select name="" id="" class="form-control">
                                        <option value="">4% Cashback</option>
                                    </select>
                                    <div class="customer">
                                        <div>New Customer <span class="purple">5</span></div>
                                        <div>Existing Customer <span class="yellow">15</span></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div id="m_chart_offer" class="m-widget27__chart" style="height: 220px">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="m-widget27__legends">
                                        <div class="m-widget27__legend purple">
                                            <span class="m-widget27__legend-bullet"></span>
                                            <span class="m-widget27__legend-text">New Customer</span>
                                        </div>
                                        <div class="m-widget27__legend yellow">
                                            <span class="m-widget27__legend-bullet"></span>
                                            <span class="m-widget27__legend-text">Existing Customer</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End::Portlet Offer Redemption-->
                </div>
            </div>
            

        </div>
    </div>
</div>




@endsection

@section("footer")
$(document).ready(function () {
    $(window).load(function() {
        demo5();
        demo7();
        donutChart();
        donutChartOffer();

    })
});
@endsection
