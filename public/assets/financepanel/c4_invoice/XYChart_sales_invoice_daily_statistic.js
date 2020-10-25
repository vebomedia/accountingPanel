document.addEventListener('DOMContentLoaded', function () {

    general.loadPackage('daterangepicker', function () {
        
    });
    
    general.loadPackage('amcharts', function () {
    var hidetable = $('#chartsales_invoice_daily_statistic').data('hidetable');
    
    var sourceUrl = panel_url('c4_invoice/readChartData/sales_invoice_daily_statistic') + '?';

    // predefined ranges
    var start = moment().startOf('month');
    var end = moment().endOf('month');
    var start_mysql = start.format('YYYY-MM-DD');
    var end_mysql = end.format('YYYY-MM-DD');
    
    $('#chartsales_invoice_daily_statistic_daterangepicker .form-control').val(start.format('DD MMMM YYYY') + ' / ' + end.format('DD MMMM YYYY'));

    $('#chartsales_invoice_daily_statistic_daterangepicker').daterangepicker({
        buttonClasses: 'm-btn btn',
        applyClass: 'btn-primary',
        cancelClass: 'btn-secondary',

        startDate: start,
        endDate: end,
        ranges: {
            [homeLang('today')]: [moment(), moment()],
            [homeLang('yesterday')]: [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            [homeLang('this_month')]: [moment().startOf('month'), moment().endOf('month')],
            [homeLang('last_month')]: [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            [homeLang('this_year')] : [moment().startOf('year'), moment()],
            [homeLang('last_year')] : [moment().subtract(1, 'years').startOf('year'), moment().subtract(1, 'years').endOf('year')]
        }
    }, function (start, end, label) {

        start_mysql = start.format('YYYY-MM-DD');
        end_mysql = end.format('YYYY-MM-DD');

        chart.dataSource.url = sourceUrl + "&startDate=" + start_mysql + "&endDate=" + end_mysql;
        chart.dataSource.load();
   
        $('#chartsales_invoice_daily_statistic_daterangepicker .form-control').val(start.format('DD MMMM YYYY') + ' / ' + end.format('DD MMMM YYYY'));

    
        if (typeof sales_invoice !== 'undefined') {
            //Datatable ... 
            sales_invoice.setTableUrlExt('dateRangeStart[issue_date]=' + start_mysql + '&dateRangeEnd[issue_date]=' + end_mysql);
            sales_invoice.reload_datatable();
            $(".date_title").html(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY') + '');
        }
    
    });

    var TableUrlExt = 'dateRangeStart[issue_date]=' + start_mysql + '&dateRangeEnd[issue_date]=' + end_mysql;
    am4core.useTheme(am4themes_animated);


    
    // ====================DATE BASED =====================================//
    //Chart
    var chart = am4core.create("chartsales_invoice_daily_statistic", am4charts.XYChart);
    chart.dataSource.url = sourceUrl + "startDate=" + start_mysql + "&endDate=" + end_mysql;

    // Create axes
    var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

    
    //=================series 205    
    var series_205 = chart.series.push(new am4charts.LineSeries());
    series_205.dataFields.valueY = "series_205";
    series_205.dataFields.dateX = "CATEGORY";
    series_205.tooltipText = "{series_205} - " + getLang('c4_invoice', 'series_205')
    series_205.strokeWidth = 2;
    series_205.minBulletDistance = 15;
    series_205.name = getLang('c4_invoice', 'series_205'); 


    // Drop-shaped tooltips
    series_205.tooltip.background.cornerRadius = 20;
    series_205.tooltip.background.strokeOpacity = 0;
    series_205.tooltip.pointerOrientation = "vertical";
    series_205.tooltip.label.minWidth = 40;
    series_205.tooltip.label.minHeight = 40;
    series_205.tooltip.label.textAlign = "middle";
    series_205.tooltip.label.textValign = "middle";

    //==========bullet
    var bullet = series_205.bullets.push(new am4charts.CircleBullet());
    bullet.circle.strokeWidth = 2;
    bullet.circle.radius = 4;
    bullet.circle.fill = am4core.color("#fff");
    var bullethover = bullet.states.create("hover");
    bullethover.properties.scale = 1.3;

            
    // =============Make a panning cursor dddddd
    chart.cursor = new am4charts.XYCursor();
    chart.cursor.behavior = "panXY";
    chart.cursor.xAxis = dateAxis;
    chart.cursor.snapToSeries = series_205; //first key in array

    //=============== 

    if(hidetable){

        // Create vertical scrollbar and place it before the value axis
        chart.scrollbarY = new am4core.Scrollbar();
        chart.scrollbarY.parent = chart.leftAxesContainer;
        chart.scrollbarY.toBack();

        // Create a horizontal scrollbar with previe and place it underneath the date axis
        chart.scrollbarX = new am4charts.XYChartScrollbar();
        chart.scrollbarX.series.push(series_205);    
        chart.scrollbarX.parent = chart.bottomAxesContainer;

    }

    // Add legend
    chart.legend = new am4charts.Legend();

    chart.events.on("ready", function () {
        dateAxis.zoom({start: 0, end: 1});
    });
    

    

    //===========START DATATABLE      
    
    if (typeof sales_invoice !== 'undefined') {
        sales_invoice.setTableUrlExt(TableUrlExt);
        sales_invoice.reload_datatable();
        $(".date_title").html(start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY') + '');
    }
        });
});