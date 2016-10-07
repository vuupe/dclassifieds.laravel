@extends('admin.layout.admin_index_layout')
@section('content')
    <section class="content-header">
        <h1>
            Dashboard
            <small>DClassifieds v3</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-edit"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ trans('admin_common.Num Ads') }}</span>
                        <span class="info-box-number">{{ $stat->num_ads }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-edit"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ trans('admin_common.Num Promo Ads') }}</span>
                        <span class="info-box-number">{{ $stat->num_promo_ads }}</span>
                    </div>
                </div>
            </div>

            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-warning"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ trans('admin_common.Reports') }}</span>
                        <span class="info-box-number">{{ $stat->reports }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">{{ trans('admin_common.Users') }}</span>
                        <span class="info-box-number">{{ $stat->users }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin_common.Ads By Date') }}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart">
                                    <canvas id="adsByDayChart" style="height: 180px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin_common.Promo Ads By Date') }}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart">
                                    <canvas id="promoAdsByDayChart" style="height: 180px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin_common.Ads By Month') }}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart">
                                    <canvas id="adsByMonthChart" style="height: 180px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('admin_common.Ads By Year') }}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart">
                                    <canvas id="adsByYearChart" style="height: 180px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('js')
    <!-- ChartJS 1.0.1 -->
    <script src="{{ asset('adminlte/plugins/chartjs/Chart.min.js') }}"></script>
    <script>
        $(function () {
            // Get context with jQuery - using jQuery's .get() method.
            var adsByDayChartCanvas = $("#adsByDayChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var areaChart = new Chart(adsByDayChartCanvas);

            <?
            $labels = [];
            $data = [];
            if(isset($stat->ads_by_date) && !empty($stat->ads_by_date)){
                foreach($stat->ads_by_date as $k => $v){
                    $labels[] = '"' . $v['date_formated'] . '"';
                    $data[] = $v['ad_count'];
                }
            }
            ?>

            var areaChartData = {
            labels: [<?=join(',', $labels)?>],
            datasets: [
                {
                    label: "Ads",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: [<?=join(',', $data)?>]
                }]
            };

            var areaChartOptions = {
                //Boolean - If we should show the scale at all
                showScale: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: false,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - Whether the line is curved between points
                bezierCurve: true,
                //Number - Tension of the bezier curve between points
                bezierCurveTension: 0.3,
                //Boolean - Whether to show a dot for each point
                pointDot: false,
                //Number - Radius of each point dot in pixels
                pointDotRadius: 4,
                //Number - Pixel width of point dot stroke
                pointDotStrokeWidth: 1,
                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                pointHitDetectionRadius: 20,
                //Boolean - Whether to show a stroke for datasets
                datasetStroke: true,
                //Number - Pixel width of dataset stroke
                datasetStrokeWidth: 2,
                //Boolean - Whether to fill the dataset with a color
                datasetFill: true,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio: true,
                //Boolean - whether to make the chart responsive to window resizing
                responsive: true
            };

            //Create the line chart
            areaChart.Line(areaChartData, areaChartOptions);

            /**
             * promo ads by date
             */
            // Get context with jQuery - using jQuery's .get() method.
            var promoAdsByDayChartCanvas = $("#promoAdsByDayChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var promoAdsAreaChart = new Chart(promoAdsByDayChartCanvas);

            <?
            $labels = [];
            $data = [];
            if(isset($stat->promo_ads_by_date) && !empty($stat->promo_ads_by_date)){
                foreach($stat->promo_ads_by_date as $k => $v){
                    $labels[] = '"' . $v['date_formated'] . '"';
                    $data[] = $v['ad_count'];
                }
            }
            ?>

            var promoAdsAreaChartData = {
            labels: [<?=join(',', $labels)?>],
            datasets: [
                {
                    label: "Promo Ads",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: [<?=join(',', $data)?>]
                }]
            };

            //Create the line chart
            promoAdsAreaChart.Line(promoAdsAreaChartData, areaChartOptions);

            /**
             * ads by month
             */
            // Get context with jQuery - using jQuery's .get() method.
            var adsByMonthChartCanvas = $("#adsByMonthChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var adsByMonthAreaChart = new Chart(adsByMonthChartCanvas);

            <?
            $labels = [];
            $data = [];
            if(isset($stat->ads_by_month) && !empty($stat->ads_by_month)){
                foreach($stat->ads_by_month as $k => $v){
                    $labels[] = '"' . $v['date_formated'] . '"';
                    $data[] = $v['ad_count'];
                }
            }
            ?>

            var adsByMonthAreaChartData = {
            labels: [<?=join(',', $labels)?>],
            datasets: [
                {
                    label: "Ads",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: [<?=join(',', $data)?>]
                }]
            };

            //Create the line chart
            adsByMonthAreaChart.Line(adsByMonthAreaChartData, areaChartOptions);

            /**
             * ads by year
             */
            // Get context with jQuery - using jQuery's .get() method.
            var adsByYearChartCanvas = $("#adsByYearChart").get(0).getContext("2d");
            // This will get the first returned node in the jQuery collection.
            var adsByYearAreaChart = new Chart(adsByYearChartCanvas);

            <?
            $labels = [];
            $data = [];
            if(isset($stat->ads_by_year) && !empty($stat->ads_by_year)){
                foreach($stat->ads_by_year as $k => $v){
                    $labels[] = '"' . $v['date_formated'] . '"';
                    $data[] = $v['ad_count'];
                }
            }
            ?>

            var adsByYearAreaChartData = {
            labels: [<?=join(',', $labels)?>],
            datasets: [
                {
                    label: "Ads",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: [<?=join(',', $data)?>]
                }]
            };

            //Create the line chart
            adsByYearAreaChart.Line(adsByYearAreaChartData, areaChartOptions);
        });
    </script>

@endsection
