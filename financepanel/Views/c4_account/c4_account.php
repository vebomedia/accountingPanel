<?php
$tableTitle = lang('c4_account._page_c4_account');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-university"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = financepanel_url('c4_account/showForm/cash_account');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_c4_account"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-university"></i>
                                    <span><?=lang('c4_account._form_cash_account'); ?></span>
                                </span>
                            </a>
                        </li>

                       
            <?php
            $encoded   = '';
            $url       = financepanel_url('c4_account/showForm/bank_account');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_c4_account"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-university"></i>
                                    <span><?=lang('c4_account._form_bank_account'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_c4_account" aria-controls="searchFormArea_c4_account" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">


        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_c4_account">
            <div class="card card-body border-light p-0">

<?php echo form_open(financepanel_url('c4_account/readC4_account/c4_account'), 'id="form_c4_account"'); ?>
                
                
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
                                    <label><?=lang('c4_account.currency'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('c4_account.list_currency');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("currency", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

                                     

                    
                        <!--  General Search -->           
                        <div class="form-group col-md-2">
                            <label><?php echo lang('home.general_search'); ?></label>
    
                        <?php $searchText = lang("c4_account.name"); ?>

                            <input type="search"  name="filterSearch" class="form-control generalSearch" placeholder="<?= $searchText; ?>" />

                        </div>


                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_c4_account">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  account_type -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_account.account_type'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_account/update');?>"
                                               data-datatable="table_c4_account" data-jsname="c4_account"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_account.account_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"account_type":"cash"}'><?=lang('c4_account.list_account_type')['cash'] ?? 'cash'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_account/update');?>"
                                               data-datatable="table_c4_account" data-jsname="c4_account"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_account.account_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"account_type":"bank"}'><?=lang('c4_account.list_account_type')['bank'] ?? 'bank'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  currency -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_account.currency'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_account/update');?>"
                                               data-datatable="table_c4_account" data-jsname="c4_account"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_account.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"TRY"}'><?=lang('c4_account.list_currency')['TRY'] ?? 'TRY'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_account/update');?>"
                                               data-datatable="table_c4_account" data-jsname="c4_account"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_account.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"USD"}'><?=lang('c4_account.list_currency')['USD'] ?? 'USD'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_account/update');?>"
                                               data-datatable="table_c4_account" data-jsname="c4_account"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_account.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"EUR"}'><?=lang('c4_account.list_currency')['EUR'] ?? 'EUR'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_account/update');?>"
                                               data-datatable="table_c4_account" data-jsname="c4_account"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_account.currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"currency":"GBP"}'><?=lang('c4_account.list_currency')['GBP'] ?? 'GBP'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  status -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_account.status'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_account/update');?>"
                                               data-datatable="table_c4_account" data-jsname="c4_account"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_account.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"1"}'><?=lang('c4_account.list_status')['1'] ?? '1'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_account/update');?>"
                                               data-datatable="table_c4_account" data-jsname="c4_account"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_account.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"2"}'><?=lang('c4_account.list_status')['2'] ?? '2'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=financepanel_url('c4_account/update');?>"
                        data-datatable="table_c4_account"  data-jsname="c4_account"
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
                        data-actionurl= "<?=financepanel_url('c4_account/update');?>"
                        data-datatable="table_c4_account"  data-jsname="c4_account"
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
                <table id="table_c4_account" class="table table-hover" width="100%" cellspacing="0" data-url="<?=financepanel_url('c4_account/readC4_account/c4_account');?>"></table>
            </div>





    </div>
</div>


<script src="<?= financepanel_url('c4_account/langJS');?>"></script>

    <script src="<?= site_url('assets/financepanel/c4_account/c4_account.js');?>"></script> 

    


