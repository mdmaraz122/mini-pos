<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #03e3fc">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Total Sales</h5>
                                        <h2 class="mb-3 font-18">{{ $data['totalSalesCount'] }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <i class="fas fa-cart-plus" style="font-size: 40px; color: #03e3fc;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #67ff00">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Total Revenue</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['totalRevenue'], 2) }} ﷼</h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #67ff00;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #ff3902">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Total Due</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['totalDue'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #ff3902;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #0324a9">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Total Profit</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['totalProfit'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #0324a9;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="text-danger">Today Data</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #03e3fc">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Today Sales</h5>
                                        <h2 class="mb-3 font-18">{{ $data['todaySalesCount'] }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <i class="fas fa-cart-plus" style="font-size: 40px; color: #03e3fc;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #67ff00">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Today Revenue</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['todayRevenue'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #67ff00;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #ff3902">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Today Due</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['todayDue'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #ff3902;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #0324a9">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Today Profit</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['todayProfit'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #0324a9;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="text-danger">Previous Day Data</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #03e3fc">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Previous Day Sales</h5>
                                        <h2 class="mb-3 font-18">{{ $data['previousDaySalesCount'] }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <i class="fas fa-cart-plus" style="font-size: 40px; color: #03e3fc;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #67ff00">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Previous Day Revenue</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['previousDayRevenue'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #67ff00;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #ff3902">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Previous Day Due</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['previousDayDue'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #ff3902;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #0324a9">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Previous Day Profit</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['previousDayProfit'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #0324a9;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="text-danger">This Month Data</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #03e3fc">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">This Month Sales</h5>
                                        <h2 class="mb-3 font-18">{{ $data['thisMonthSalesCount'] }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <i class="fas fa-cart-plus" style="font-size: 40px; color: #03e3fc;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #67ff00">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">This Month Revenue</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['thisMonthRevenue'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #67ff00;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #ff3902">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">This Month Due</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['thisMonthDue'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #ff3902;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #0324a9">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">This Month Profit</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['thisMonthProfit'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #0324a9;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="text-danger">Previous Month Data</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #03e3fc">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Previous Month Sales</h5>
                                        <h2 class="mb-3 font-18">{{ $data['previousMonthSalesCount'] }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <i class="fas fa-cart-plus" style="font-size: 40px; color: #03e3fc;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #67ff00">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Previous Month Revenue</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['previousMonthRevenue'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #67ff00;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #ff3902">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Previous Month Due</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['previousMonthDue'], 2).' ﷼' }} </h2>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #ff3902;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #0324a9">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Previous Month Profit</h5>
                                        <h2 class="mb-3 font-18">{{ number_format($data['previousMonthProfit'], 2).' ﷼' }} </h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <span style="font-size: 40px; color: #0324a9;">﷼</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="text-danger">Others</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #a103fc">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Total Category</h5>
                                        <h2 class="mb-3 font-18">{{ $data['totalCategory'] }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <i class="fas fa-box" style="font-size: 40px; color: #a103fc;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #ad914d">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Total Brand</h5>
                                        <h2 class="mb-3 font-18">{{ $data['totalBrand'] }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <i class="fas fa-building" style="font-size: 40px; color: #ad914d;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #218400">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Total Product</h5>
                                        <h2 class="mb-3 font-18">{{ $data['totalProduct'] }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <i class="fas fa-shopping-bag" style="font-size: 40px; color: #218400;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="box-shadow: 0px 3px 7px -2px #1a006d">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                    <div class="card-content">
                                        <h5 class="font-15">Total Customer</h5>
                                        <h2 class="mb-3 font-18">{{ $data['totalCustomer'] }}</h2>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0 d-flex align-items-center justify-content-center">
                                    <div class="text-center">
                                        <i class="fas fa-shopping-bag" style="font-size: 40px; color: #1a006d;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
