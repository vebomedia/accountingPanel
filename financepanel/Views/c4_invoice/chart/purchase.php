
<!-- Styles -->
<div class="card border-light mb-0">
    <div class="card-header bg-transparent">

        <div class="row">
            <div class="col-xl-8 col-md-6 col-sm-12">
                <h5 class=""><i class="far fa-money-bill-alt"></i> <?= lang('c4_invoice._chart_purchase'); ?>   &nbsp; </h5> 
            </div>
<!--            <div class="col"> 

                <small><span class="date_title"></span> </small>


            </div>-->
            <div class="col-xl-4 col-md-6 col-sm-12 ml-auto float-right">

                <div class="input-group pull-right" id="chartpurchase_daterangepicker">
                    <input type="text" class="form-control" readonly="" placeholder=""/>
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card card-body p-0">

        <div class="chart">
            <div id="chartpurchase" class="xyChartDiv" data-hidetable = "false"></div>

        </div>
    </div>

</div>



    
<?php 
//$hideTable is extra option expected come from dashboard panel_view function.

if(!isset($hideTable)){
    echo financepanel_view('c4_invoice/purchase_invoice', ['extraCondition' => []]);
}
?>            
<script src="<?= site_url('assets/financepanel/c4_invoice/XYChart_purchase.js');?>"></script>