<?php

$url = financepanel_url('c4_stock_movement/save/outflow_stock_movement');
$hiddenArray = [];

if( !empty($formData['c4_stock_movement_id']) )
{
    $url .= '/' . $formData['c4_stock_movement_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="outflow_stock_movement" autocomplete="off" role="presentation" data-pageslug="outflow_stock_movement" data-formslug="outflow_stock_movement"  data-jsname="outflow_stock_movement" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js,datepicker,input_number" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("inflow", $formData['inflow'] ?? "0", '', 'hidden');?> 
<?=form_input("_formSlug", $formData['_formSlug'] ?? "outflow_stock_movement", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "outflow_stock_movement", '', 'hidden');?> 
<?=form_input("c4_stock_movement_id", $formData['c4_stock_movement_id'] ?? "", '', 'hidden');?> 
<?=form_input("inflow", '0', '', 'hidden');?>

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-truck-monster"></i> <?=lang('c4_stock_movement._form_outflow_stock_movement'); ?> </h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">


    <div class="alert alert-danger alert-dismissible formAlert d-none" role="alert" >
        <div class=""><span class="sr-only">Errors...</span></div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

        

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_c4_shipment_document_id">
            <label for="c4_shipment_document_id" class="required col-form-label"> <?=lang('c4_stock_movement.c4_shipment_document_id'); ?></label>
            
            
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
                    <div class="input-group">
                        
                        <?php echo form_dropdown("c4_shipment_document_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. financepanel_url('c4_stock_movement/getAllC4_shipment_document') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="outflow_stock_movement"
      data-rprimarykey="c4_shipment_document_id" data-getrelationurl="c4_stock_movement/getAllC4_shipment_document"
      data-rkeyfield="c4_shipment_document_id" data-rvaluefield="description" data-rvaluefield2=""
      data-required ="required" id="c4_shipment_document_id9833" data-newinputname="new_c4_shipment_document_id""
      data-optionview="{description}" data-selectedview="{description}"  data-titleview="ID: {c4_shipment_document_id}"'); ?>
                        
                            
                    </div>

                    

        </div>

         <div class="form-group" id="groupField_product_id">
            <label for="product_id" class="required col-form-label"> <?=lang('c4_stock_movement.product_id'); ?></label>
            
            
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
                    <div class="input-group">
                        
                        <?php echo form_dropdown("product_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. financepanel_url('c4_stock_movement/getAllProduct') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="outflow_stock_movement"
      data-rprimarykey="product_id" data-getrelationurl="c4_stock_movement/getAllProduct"
      data-rkeyfield="product_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="product_id4843" data-newinputname="new_product_id""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {product_id}"'); ?>
                        
                            
                    </div>

                    

        </div>

         <div class="form-group" id="groupField_date">
            <label for="date" class="required col-form-label"> <?=lang('c4_stock_movement.date'); ?></label>
            
                            <?php 
                    if(!isset($formData['date'])){
                        $formData['date'] = date('Y-m-d');
                    }
                ?>
                    <div class="input-group date">
                        
                        <?php
                        echo form_input("date", $formData['date'] ?? '', ' id="date" class="form-control datepicker" required  ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_quantity">
            <label for="quantity" class="required col-form-label"> <?=lang('c4_stock_movement.quantity'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("quantity", $formData['quantity'] ?? '', ' id="quantity" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

















</div>

<div class="modal-footer">
    
    
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('home.dismiss');?></button>
    <button type="submit" class="btn btn-primary"><?=lang('home.save');?></button>
</div>

<?php echo form_close(); ?>