<?php
$tableTitle = lang('c4_transaction._page_c4_transaction');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-money-bill-wave-alt"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = financepanel_url('c4_transaction/showForm/money_in');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_c4_transaction"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-money-bill-wave-alt"></i>
                                    <span><?=lang('c4_transaction._form_money_in'); ?></span>
                                </span>
                            </a>
                        </li>

                       
            <?php
            $encoded   = '';
            $url       = financepanel_url('c4_transaction/showForm/money_out');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_c4_transaction"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="far fa-money-bill-alt"></i>
                                    <span><?=lang('c4_transaction._form_money_out'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_c4_transaction" aria-controls="searchFormArea_c4_transaction" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">


        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_c4_transaction">
            <div class="card card-body border-light p-0">

<?php echo form_open(financepanel_url('c4_transaction/readC4_transaction/c4_transaction'), 'id="form_c4_transaction"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">
                                    
                <!--  c4_account_id --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_c4_account_id"> <?=lang('c4_transaction.c4_account_id'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['c4_account_id']))
                        {
                            $query_result =  getC4_account(['c4_account_id'=>$formData['c4_account_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_account_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("c4_account_id", $option, '', ' class="form-control select2_js formSearch"
      id="search_c4_account_id"
      data-ajax--url="'. financepanel_url('c4_transaction/getAllC4_account') . '"
      data-getrelationurl="'. financepanel_url('c4_transaction/getAllC4_account') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="c4_account_id" 
      data-rkeyfield="c4_account_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {c4_account_id}" 
      data-relationformid="form_c4_transaction" 
'); ?>
                        
    
                </div>

                <!-- /c4_account_id  -->        

                                <!--  transaction_type -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('c4_transaction.transaction_type'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('c4_transaction.list_transaction_type');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("transaction_type", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

            
                                <!--  debit_currency -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('c4_transaction.debit_currency'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('c4_transaction.list_debit_currency');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("debit_currency", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

            
                                <!--  credit_currency -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('c4_transaction.credit_currency'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('c4_transaction.list_credit_currency');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("credit_currency", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

                                     

                    
                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_c4_transaction">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  transaction_type -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_transaction.transaction_type'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.transaction_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"transaction_type":"account_debit"}'><?=lang('c4_transaction.list_transaction_type')['account_debit'] ?? 'account_debit'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.transaction_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"transaction_type":"account_credit"}'><?=lang('c4_transaction.list_transaction_type')['account_credit'] ?? 'account_credit'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.transaction_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"transaction_type":"contact_debit"}'><?=lang('c4_transaction.list_transaction_type')['contact_debit'] ?? 'contact_debit'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.transaction_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"transaction_type":"contact_credit"}'><?=lang('c4_transaction.list_transaction_type')['contact_credit'] ?? 'contact_credit'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  debit_currency -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_transaction.debit_currency'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.debit_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"debit_currency":"TRY"}'><?=lang('c4_transaction.list_debit_currency')['TRY'] ?? 'TRY'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.debit_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"debit_currency":"USD"}'><?=lang('c4_transaction.list_debit_currency')['USD'] ?? 'USD'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.debit_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"debit_currency":"EUR"}'><?=lang('c4_transaction.list_debit_currency')['EUR'] ?? 'EUR'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.debit_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"debit_currency":"GBP"}'><?=lang('c4_transaction.list_debit_currency')['GBP'] ?? 'GBP'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  credit_currency -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('c4_transaction.credit_currency'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.credit_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"credit_currency":"TRY"}'><?=lang('c4_transaction.list_credit_currency')['TRY'] ?? 'TRY'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.credit_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"credit_currency":"USD"}'><?=lang('c4_transaction.list_credit_currency')['USD'] ?? 'USD'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.credit_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"credit_currency":"EUR"}'><?=lang('c4_transaction.list_credit_currency')['EUR'] ?? 'EUR'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('c4_transaction/update');?>"
                                               data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("c4_transaction.credit_currency");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"credit_currency":"GBP"}'><?=lang('c4_transaction.list_credit_currency')['GBP'] ?? 'GBP'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=financepanel_url('c4_transaction/delete');?>"
                        data-datatable="table_c4_transaction" data-jsname="c4_transaction"
                        data-question="<?=lang("home.areyousure");?>"
                        data-subtitle="<?=lang("home.will_be_deleted");?>"
                        data-processingtitle="<?=lang("home.deleted");?>" 
                        data-postdata='{"deleted_at":"1"}'
                        ><?= lang('home.delete'); ?>&nbsp; <span class="badge badge-light selectedCount">0</span>
                        </a>
                    </div>
             



                    

                </div>


            </div>

        </div>
        <!-- end: Batch Processing -->



            <div class="table-responsive">
                <table id="table_c4_transaction" class="table table-hover" width="100%" cellspacing="0" data-url="<?=financepanel_url('c4_transaction/readC4_transaction/c4_transaction');?>"></table>
            </div>





    </div>
</div>


<script src="<?= financepanel_url('c4_transaction/langJS');?>"></script>

    <script src="<?= site_url('assets/financepanel/c4_transaction/c4_transaction.js');?>"></script> 

    


