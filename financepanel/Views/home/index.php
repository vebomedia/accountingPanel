<div class="row">

    
        <div class="col-lg-2 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-secondary o-hidden h-100" data-viewplace="ondashboard" data-action="readStatistic" data-type="number" 
                data-ajaxurl="<?= financepanel_url('c4_invoice/readStatistic/sales_invoice/Sales-Total-Remaining');?>" data-card_slug="Sales-Total-Remaining" data-alliesname="SUM_remaining">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('c4_invoice.Sales-Total-Remaining'); ?></div>
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Sales-Total-Remaining" id="Sales-Total-Remaining"><!-- Data Comes With AJAX Here --></div>
                </div>
                
    <a class="card-footer p-1 text-white clearfix small z-1" href="<?=financepanel_url('c4_invoice/sales_invoice');?>"">
        <span class="float-left"><?=lang('home.view_more');?></span>
        <span class="float-right"><i class="fas fa-angle-right"></i></span>
    </a>    
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-secondary o-hidden h-100" data-viewplace="ondashboard" data-action="readStatistic" data-type="radiusDonut" 
                data-ajaxurl="<?= financepanel_url('c4_invoice/readStatistic/sales_invoice/Sales-Invoice-Gross-Total');?>" data-card_slug="Sales-Invoice-Gross-Total" data-alliesname="SUM_gross_total">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('c4_invoice.Sales-Invoice-Gross-Total'); ?></div>
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Sales-Invoice-Gross-Total" id="Sales-Invoice-Gross-Total"><!-- Data Comes With AJAX Here --></div>
                </div>
                
    <a class="card-footer p-1 text-white clearfix small z-1" href="<?=financepanel_url('c4_invoice/sales_invoice');?>"">
        <span class="float-left"><?=lang('home.view_more');?></span>
        <span class="float-right"><i class="fas fa-angle-right"></i></span>
    </a>    
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-danger o-hidden h-100" data-viewplace="ondashboard" data-action="readStatistic" data-type="number" 
                data-ajaxurl="<?= financepanel_url('c4_invoice/readStatistic/sales_invoice/Past-Due-Sales-Remaining');?>" data-card_slug="Past-Due-Sales-Remaining" data-alliesname="SUM_remaining">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('c4_invoice.Past-Due-Sales-Remaining'); ?></div>
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Past-Due-Sales-Remaining" id="Past-Due-Sales-Remaining"><!-- Data Comes With AJAX Here --></div>
                </div>
                
    <a class="card-footer p-1 text-white clearfix small z-1" href="<?=financepanel_url('c4_invoice/sales_invoice');?>"">
        <span class="float-left"><?=lang('home.view_more');?></span>
        <span class="float-right"><i class="fas fa-angle-right"></i></span>
    </a>    
            </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-secondary o-hidden h-100" data-viewplace="ondashboard" data-action="readStatistic" data-type="piechart" 
                data-ajaxurl="<?= financepanel_url('c4_invoice/readStatistic/sales_invoice/Invoice-types');?>" data-card_slug="Invoice-types" data-alliesname="SUM_gross_total">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('c4_invoice.Invoice-types'); ?></div>
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Invoice-types" id="Invoice-types"><!-- Data Comes With AJAX Here --></div>
                </div>
                
    <a class="card-footer p-1 text-white clearfix small z-1" href="<?=financepanel_url('c4_invoice/sales_invoice');?>"">
        <span class="float-left"><?=lang('home.view_more');?></span>
        <span class="float-right"><i class="fas fa-angle-right"></i></span>
    </a>    
            </div>
        </div>

</div>
    <!-- Charts -->
    <div class="row">
        <div class="col-xl-6 col-sm-12 mb-2">
                    <div class="col-xl-12 col-sm-12">    
                    <?php echo financepanel_view('c4_invoice/chart/sales_invoice_daily_statistic', ['hideTable' => true]);?>                    </div>
                    </div>
<div class="col-xl-6 col-sm-12 mb-2">
                    <div class="col-xl-12 col-sm-12">    
                    <?php echo financepanel_view('c4_invoice/chart/purchase', ['hideTable' => true]);?>                    </div>
                    </div>
    </div>
    <!-- /Charts -->
