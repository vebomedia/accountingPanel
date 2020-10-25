<?php
$tableTitle = lang('c4_stock_movement._page_outflow_stock_movement');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="fas fa-truck-monster"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = financepanel_url('c4_stock_movement/showForm/outflow_stock_movement');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_outflow_stock_movement"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="fas fa-truck-monster"></i>
                                    <span><?=lang('c4_stock_movement._form_outflow_stock_movement'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_outflow_stock_movement" aria-controls="searchFormArea_outflow_stock_movement" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">


        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_outflow_stock_movement">
            <div class="card card-body border-light p-0">

<?php echo form_open(financepanel_url('c4_stock_movement/readC4_stock_movement/outflow_stock_movement'), 'id="form_outflow_stock_movement"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">
                                    
                <!--  c4_shipment_document_id --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_c4_shipment_document_id"> <?=lang('c4_stock_movement.c4_shipment_document_id'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['c4_shipment_document_id']))
                        {
                            $query_result =  getC4_shipment_document(['c4_shipment_document_id'=>$formData['c4_shipment_document_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_shipment_document_id'] =>  $query_result['description']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("c4_shipment_document_id", $option, '', ' class="form-control select2_js formSearch"
      id="search_c4_shipment_document_id"
      data-ajax--url="'. financepanel_url('c4_stock_movement/getAllC4_shipment_document') . '"
      data-getrelationurl="'. financepanel_url('c4_stock_movement/getAllC4_shipment_document') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="c4_shipment_document_id" 
      data-rkeyfield="c4_shipment_document_id" data-rvaluefield="description" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{description}" data-selectedview="{description}"  data-titleview="ID: {c4_shipment_document_id}" 
      data-relationformid="form_outflow_stock_movement" 
'); ?>
                        
    
                </div>

                <!-- /c4_shipment_document_id  -->        
                                    
                <!--  product_id --> 
                                    
                <div class="form-group col-md-2 col-sm-6">
                    <label for="search_product_id"> <?=lang('c4_stock_movement.product_id'); ?></label>
                
                    <?php 
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['product_id']))
                        {
                            $query_result =  getProduct(['product_id'=>$formData['product_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['product_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                     
                        <?php echo form_dropdown("product_id", $option, '', ' class="form-control select2_js formSearch"
      id="search_product_id"
      data-ajax--url="'. financepanel_url('c4_stock_movement/getAllProduct') . '"
      data-getrelationurl="'. financepanel_url('c4_stock_movement/getAllProduct') . '"
      data-placeholder="'. lang('home.all') . '" 
      data-theme="bootstrap4" 
      data-selectonclose="true"
      data-minimuminputlength="0"
      data-rprimarykey="product_id" 
      data-rkeyfield="product_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="permit_empty"
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {product_id}" 
      data-relationformid="form_outflow_stock_movement" 
'); ?>
                        
    
                </div>

                <!-- /product_id  -->        

                                <!--  inflow -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('c4_stock_movement.inflow'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('c4_stock_movement.list_inflow');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("inflow", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

                                     

                    
                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_outflow_stock_movement">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=financepanel_url('c4_stock_movement/update');?>"
                        data-datatable="table_outflow_stock_movement"  data-jsname="outflow_stock_movement"
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
                        data-actionurl= "<?=financepanel_url('c4_stock_movement/update');?>"
                        data-datatable="table_outflow_stock_movement"  data-jsname="outflow_stock_movement"
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
                <table id="table_outflow_stock_movement" class="table table-hover" width="100%" cellspacing="0" data-url="<?=financepanel_url('c4_stock_movement/readC4_stock_movement/outflow_stock_movement');?>"></table>
            </div>





    </div>
</div>


<script src="<?= financepanel_url('c4_stock_movement/langJS');?>"></script>

    <script src="<?= site_url('assets/financepanel/c4_stock_movement/outflow_stock_movement.js');?>"></script> 

    


