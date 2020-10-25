<?php
$tableTitle = lang('product._page_product');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-tags"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = financepanel_url('product/showForm/product');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_product"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-tags"></i>
                                    <span><?=lang('product._form_product'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_product" aria-controls="searchFormArea_product" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">


        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_product">
            <div class="card card-body border-light p-0">

<?php echo form_open(financepanel_url('product/readProduct/product'), 'id="form_product"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">

                                <!--  currency -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('product.currency'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('product.list_currency');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("currency", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

            
                                <!--  buying_currency -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('product.buying_currency'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('product.list_buying_currency');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("buying_currency", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

            
                                <!--  communications_tax_type -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('product.communications_tax_type'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('product.list_communications_tax_type');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("communications_tax_type", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

            
                                <!--  purchase_excise_duty_type -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('product.purchase_excise_duty_type'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('product.list_purchase_excise_duty_type');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("purchase_excise_duty_type", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

            
                                <!--  sales_excise_duty_type -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('product.sales_excise_duty_type'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('product.list_sales_excise_duty_type');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("sales_excise_duty_type", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

                                     

                    
                        <!--  General Search -->           
                        <div class="form-group col-md-2">
                            <label><?php echo lang('home.general_search'); ?></label>
    
                        <?php $searchText = lang("product.name"); ?>

                            <input type="search"  name="filterSearch" class="form-control generalSearch" placeholder="<?= $searchText; ?>" />

                        </div>


                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_product">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  buying_currency -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('product.buying_currency'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.buying_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"buying_currency":"TRY"}'><?=lang('product.list_buying_currency')['TRY'] ?? 'TRY'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.buying_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"buying_currency":"USD"}'><?=lang('product.list_buying_currency')['USD'] ?? 'USD'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.buying_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"buying_currency":"EUR"}'><?=lang('product.list_buying_currency')['EUR'] ?? 'EUR'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.buying_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"buying_currency":"GBP"}'><?=lang('product.list_buying_currency')['GBP'] ?? 'GBP'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  currency -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('product.currency'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"TRY"}'><?=lang('product.list_currency')['TRY'] ?? 'TRY'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"USD"}'><?=lang('product.list_currency')['USD'] ?? 'USD'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"EUR"}'><?=lang('product.list_currency')['EUR'] ?? 'EUR'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"GBP"}'><?=lang('product.list_currency')['GBP'] ?? 'GBP'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  communications_tax_type -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('product.communications_tax_type'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.communications_tax_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"communications_tax_type":"percentage"}'><?=lang('product.list_communications_tax_type')['percentage'] ?? 'percentage'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.communications_tax_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"communications_tax_type":"amount"}'><?=lang('product.list_communications_tax_type')['amount'] ?? 'amount'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  purchase_excise_duty_type -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('product.purchase_excise_duty_type'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.purchase_excise_duty_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"purchase_excise_duty_type":"percentage"}'><?=lang('product.list_purchase_excise_duty_type')['percentage'] ?? 'percentage'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.purchase_excise_duty_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"purchase_excise_duty_type":"amount"}'><?=lang('product.list_purchase_excise_duty_type')['amount'] ?? 'amount'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  sales_excise_duty_type -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('product.sales_excise_duty_type'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.sales_excise_duty_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"sales_excise_duty_type":"percentage"}'><?=lang('product.list_sales_excise_duty_type')['percentage'] ?? 'percentage'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.sales_excise_duty_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"sales_excise_duty_type":"amount"}'><?=lang('product.list_sales_excise_duty_type')['amount'] ?? 'amount'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  status -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('product.status'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"1"}'><?=lang('product.list_status')['1'] ?? '1'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('product/update');?>"
                                               data-datatable="table_product" data-jsname="product"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("product.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"2"}'><?=lang('product.list_status')['2'] ?? '2'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=financepanel_url('product/update');?>"
                        data-datatable="table_product"  data-jsname="product"
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
                        data-actionurl= "<?=financepanel_url('product/update');?>"
                        data-datatable="table_product"  data-jsname="product"
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
                <table id="table_product" class="table table-hover" width="100%" cellspacing="0" data-url="<?=financepanel_url('product/readProduct/product');?>"></table>
            </div>





    </div>
</div>


<script src="<?= financepanel_url('product/langJS');?>"></script>

    <script src="<?= site_url('assets/financepanel/product/product.js');?>"></script> 

    



            <script src="<?= financepanel_url('c4_invoice_item/langJS'); ?>"></script>

            