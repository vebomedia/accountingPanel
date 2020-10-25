<?php
$tableTitle = lang('c4_invoice._page_sales_invoice');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-file-invoice"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = financepanel_url('c4_invoice/showForm/sales_invoice');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_sales_invoice"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-file-invoice"></i>
                                    <span><?=lang('c4_invoice._form_sales_invoice'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
                <li class="nav-item">
                    <a href="<?php echo financepanel_url('c4_invoice/showchart/sales_invoice_daily_statistic'); ?>"
                       class="nav-link btn btn-sm btn-primary mr-1 mr-1">
                        <span>
                            <i class="fas fa-chart-line"></i>
                            <span><?= lang("c4_invoice._chart_sales_invoice_daily_statistic") ?></span>
                        </span>
                    </a>
                </li>

    
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_sales_invoice" aria-controls="searchFormArea_sales_invoice" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">

    <!--  Start Card Row -->
    <div class="row">

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-secondary o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= financepanel_url('c4_invoice/readStatistic/sales_invoice/Sales-Total-Remaining');?>" 
                    data-card_slug="Sales-Total-Remaining" data-alliesname="SUM_remaining">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('c4_invoice.Sales-Total-Remaining'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Sales-Total-Remaining" id="Sales-Total-Remaining"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-secondary o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="radiusDonut" data-ajaxurl="<?= financepanel_url('c4_invoice/readStatistic/sales_invoice/Sales-Invoice-Gross-Total');?>" 
                    data-card_slug="Sales-Invoice-Gross-Total" data-alliesname="SUM_gross_total">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('c4_invoice.Sales-Invoice-Gross-Total'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Sales-Invoice-Gross-Total" id="Sales-Invoice-Gross-Total"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-danger o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="number" data-ajaxurl="<?= financepanel_url('c4_invoice/readStatistic/sales_invoice/Past-Due-Sales-Remaining');?>" 
                    data-card_slug="Past-Due-Sales-Remaining" data-alliesname="SUM_remaining">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('c4_invoice.Past-Due-Sales-Remaining'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Past-Due-Sales-Remaining" id="Past-Due-Sales-Remaining"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 mt-1 mb-1">
            <div class="card text-white bg-secondary o-hidden h-100" data-viewplace="onpage" 
                data-action="readStatistic" data-type="piechart" data-ajaxurl="<?= financepanel_url('c4_invoice/readStatistic/sales_invoice/Invoice-types');?>" 
                    data-card_slug="Invoice-types" data-alliesname="SUM_gross_total">
                <div class="card-header p-2"><i class = "fas fa-chart-pie"></i> <?= lang('c4_invoice.Invoice-types'); ?></div>    
                <div class="card-body p-1 align-items-center d-flex justify-content-center">
                    <div class="" data-cardvalue="Invoice-types" id="Invoice-types"><!-- Data Comes Here --></div>
                </div>
            </div>
        </div>

    </div>
    <!--  End Card Row -->

        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_sales_invoice">
            <div class="card card-body border-light p-0">

<?php echo form_open(financepanel_url('c4_invoice/readC4_invoice/sales_invoice'), 'id="form_sales_invoice"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">
                                    
                <!--  contact_id --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_contact_id"> <?=lang('c4_invoice.contact_id'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['contact_id']))
                        {
                            $query_result =  getContact(['contact_id'=>$formData['contact_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['contact_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("contact_id", $option, '', ' class="form-control select2_js formSearch"
      id="search_contact_id"
      data-ajax--url="'. financepanel_url('c4_invoice/getAllContact') . '"
      data-getrelationurl="'. financepanel_url('c4_invoice/getAllContact') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="contact_id" 
      data-rkeyfield="contact_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {contact_id}" 
      data-relationformid="form_sales_invoice" 
'); ?>
                        
    
                </div>

                <!-- /contact_id  -->        

                                <!--  currency -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('c4_invoice.currency'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('c4_invoice.list_currency');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("currency", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

                                     

                    
                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_sales_invoice">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  invoice_type -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_invoice.invoice_type'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_type":"sales_invoice"}'><?=lang('c4_invoice.list_invoice_type')['sales_invoice'] ?? 'sales_invoice'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_type":"purchase_bill"}'><?=lang('c4_invoice.list_invoice_type')['purchase_bill'] ?? 'purchase_bill'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  invoice_status -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_invoice.invoice_status'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"DRAFT"}'><?=lang('c4_invoice.list_invoice_status')['DRAFT'] ?? 'DRAFT'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"SENT"}'><?=lang('c4_invoice.list_invoice_status')['SENT'] ?? 'SENT'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"PAID"}'><?=lang('c4_invoice.list_invoice_status')['PAID'] ?? 'PAID'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"CANCELLED"}'><?=lang('c4_invoice.list_invoice_status')['CANCELLED'] ?? 'CANCELLED'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"REFUNDED"}'><?=lang('c4_invoice.list_invoice_status')['REFUNDED'] ?? 'REFUNDED'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"PARTIALLY_PAID"}'><?=lang('c4_invoice.list_invoice_status')['PARTIALLY_PAID'] ?? 'PARTIALLY_PAID'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"PARTIALLY_REFUNDED"}'><?=lang('c4_invoice.list_invoice_status')['PARTIALLY_REFUNDED'] ?? 'PARTIALLY_REFUNDED'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"MARKED_AS_REFUNDED"}'><?=lang('c4_invoice.list_invoice_status')['MARKED_AS_REFUNDED'] ?? 'MARKED_AS_REFUNDED'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"UNPAID"}'><?=lang('c4_invoice.list_invoice_status')['UNPAID'] ?? 'UNPAID'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_status":"PAYMENT_PENDING"}'><?=lang('c4_invoice.list_invoice_status')['PAYMENT_PENDING'] ?? 'PAYMENT_PENDING'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  currency -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_invoice.currency'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"TRY"}'><?=lang('c4_invoice.list_currency')['TRY'] ?? 'TRY'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"USD"}'><?=lang('c4_invoice.list_currency')['USD'] ?? 'USD'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"EUR"}'><?=lang('c4_invoice.list_currency')['EUR'] ?? 'EUR'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"GBP"}'><?=lang('c4_invoice.list_currency')['GBP'] ?? 'GBP'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  invoice_discount_type -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_invoice.invoice_discount_type'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_discount_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_discount_type":"percentage"}'><?=lang('c4_invoice.list_invoice_discount_type')['percentage'] ?? 'percentage'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                                               data-datatable="table_sales_invoice" data-jsname="sales_invoice"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_invoice.invoice_discount_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"invoice_discount_type":"amount"}'><?=lang('c4_invoice.list_invoice_discount_type')['amount'] ?? 'amount'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                        data-datatable="table_sales_invoice"  data-jsname="sales_invoice"
                        data-question="<?=lang("home.areyousure");?>"
                        data-subtitle="<?=lang("home.will_be_deleted");?>"
                        data-processingtitle="<?=lang("home.deleted");?>" 
                        data-postdata='{"deleted_at":"1"}'
                        ><?= lang('home.delete'); ?>&nbsp; <span class="badge badge-light selectedCount">0</span>
                        </a>
                    </div>

                    <div class="btn-group btn-group-sm ml-2 undelete_link" style="display:none" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=financepanel_url('c4_invoice/update');?>"
                        data-datatable="table_sales_invoice"  data-jsname="sales_invoice"
                        data-question="<?=lang("home.areyousure");?>"
                        data-subtitle="<?=lang("home.will_be_restored");?>"
                        data-processingtitle="<?=lang("home.restoring");?>" 
                        data-postdata='{"deleted_at":"0"}'
                        ><?= lang('home.restore'); ?>&nbsp; <span class="badge badge-light selectedCount">0</span>
                        </a>
                    </div>
             



                    

                </div>


            </div>

        </div>
        <!-- end: Batch Processing -->



            <div class="table-responsive">
                <table id="table_sales_invoice" class="table table-hover" width="100%" cellspacing="0" data-url="<?=financepanel_url('c4_invoice/readC4_invoice/sales_invoice');?>"></table>
            </div>





    </div>
</div>


<script src="<?= financepanel_url('c4_invoice/langJS');?>"></script>

    <script src="<?= site_url('assets/financepanel/c4_invoice/sales_invoice.js');?>"></script> 

    



            <script src="<?= financepanel_url('c4_invoice_item/langJS'); ?>"></script>

            