<?php
$tableTitle = lang('c4_transaction_history_item._page_c4_transaction_history_item');
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
            $url       = financepanel_url('c4_transaction_history_item/showForm/c4_transaction_history_item');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_c4_transaction_history_item"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-money-bill-wave-alt"></i>
                                    <span><?=lang('c4_transaction_history_item._form_c4_transaction_history_item'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_c4_transaction_history_item" aria-controls="searchFormArea_c4_transaction_history_item" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">


        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_c4_transaction_history_item">
            <div class="card card-body border-light p-0">

<?php echo form_open(financepanel_url('c4_transaction_history_item/readC4_transaction_history_item/c4_transaction_history_item'), 'id="form_c4_transaction_history_item"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">
                                    
                <!--  c4_transaction_id --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_c4_transaction_id"> <?=lang('c4_transaction_history_item.c4_transaction_id'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['c4_transaction_id']))
                        {
                            $query_result =  getC4_transaction(['c4_transaction_id'=>$formData['c4_transaction_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_transaction_id'] =>  $query_result['transaction_type']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("c4_transaction_id", $option, '', ' class="form-control select2_js formSearch"
      id="search_c4_transaction_id"
      data-ajax--url="'. financepanel_url('c4_transaction_history_item/getAllC4_transaction') . '"
      data-getrelationurl="'. financepanel_url('c4_transaction_history_item/getAllC4_transaction') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="c4_transaction_id" 
      data-rkeyfield="c4_transaction_id" data-rvaluefield="transaction_type" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{transaction_type}" data-selectedview="{transaction_type}"  data-titleview="ID: {c4_transaction_id}" 
      data-relationformid="form_c4_transaction_history_item" 
'); ?>
                        
    
                </div>

                <!-- /c4_transaction_id  -->        
                         

                    
                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_c4_transaction_history_item">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=financepanel_url('c4_transaction_history_item/delete');?>"
                        data-datatable="table_c4_transaction_history_item" data-jsname="c4_transaction_history_item"
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
                <table id="table_c4_transaction_history_item" class="table table-hover" width="100%" cellspacing="0" data-url="<?=financepanel_url('c4_transaction_history_item/readC4_transaction_history_item/c4_transaction_history_item');?>"></table>
            </div>





    </div>
</div>


<script src="<?= financepanel_url('c4_transaction_history_item/langJS');?>"></script>

    <script src="<?= site_url('assets/financepanel/c4_transaction_history_item/c4_transaction_history_item.js');?>"></script> 

    


