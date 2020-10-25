<?php

$url = financepanel_url('c4_invoice_item/save/perchase_invoice_items');
$hiddenArray = [];

if( !empty($formData['c4_invoice_item_id']) )
{
    $url .= '/' . $formData['c4_invoice_item_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="perchase_invoice_items" autocomplete="off" role="presentation" data-pageslug="perchase_invoice_items" data-formslug="perchase_invoice_items"  data-jsname="perchase_invoice_items" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js,input_number,INVOICE_ITEM_CALCULATION" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "perchase_invoice_items", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "perchase_invoice_items", '', 'hidden');?> 
<?=form_input("c4_invoice_item_id", $formData['c4_invoice_item_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-sign-out-alt"></i> <?=lang('c4_invoice_item._form_perchase_invoice_items'); ?> </h5>
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

         <div class="form-group" id="groupField_c4_invoice_id">
            <label for="c4_invoice_id" class="required col-form-label"> <?=lang('c4_invoice_item.c4_invoice_id'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['c4_invoice_id']))
                        {
                            $query_result =  getC4_invoice(['c4_invoice_id'=>$formData['c4_invoice_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['c4_invoice_id'] =>  $query_result['description']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("c4_invoice_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. financepanel_url('c4_invoice_item/getAllC4_invoice') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="perchase_invoice_items"
      data-rprimarykey="c4_invoice_id" data-getrelationurl="c4_invoice_item/getAllC4_invoice"
      data-rkeyfield="c4_invoice_id" data-rvaluefield="description" data-rvaluefield2=""
      data-required ="required" id="c4_invoice_id7259" data-newinputname="new_c4_invoice_id""
      data-optionview="{description}" data-selectedview="{description}"  data-titleview="ID: {c4_invoice_id}"'); ?>
                        
                            
                    </div>

                    

        </div>

         <div class="form-group" id="groupField_product_id">
            <label for="product_id" class="required col-form-label"> <?=lang('c4_invoice_item.product_id'); ?></label>
            
            
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
      data-ajax--url="'. financepanel_url('c4_invoice_item/getAllProduct') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="perchase_invoice_items"
      data-rprimarykey="product_id" data-getrelationurl="c4_invoice_item/getAllProduct"
      data-rkeyfield="product_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="product_id3686" data-newinputname="new_product_id""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {product_id}"    data-fillto="name as name, list_price as unit_price, vat_rate"'); ?>
                        
                            
                    </div>

                    

        </div>

         <div class="form-group" id="groupField_name">
            <label for="name" class="required col-form-label"> <?=lang('c4_invoice_item.name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("name", $formData['name'] ?? '', '  id="name" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_quantity">
            <label for="quantity" class="required col-form-label"> <?=lang('c4_invoice_item.quantity'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("quantity", $formData['quantity'] ?? '1.0000', ' id="quantity" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_unit_price">
            <label for="unit_price" class="required col-form-label"> <?=lang('c4_invoice_item.unit_price'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("unit_price", $formData['unit_price'] ?? '', ' id="unit_price" class="form-control input_number INVOICE_ITEM_CALCULATION" required maxlength="15"  data-unit_price_field="unit_price"  data-quantity_field="quantity"  data-vat_rate_field="vat_rate"  data-discount_value_field="discount_value"  data-discount_type_field="discount_type"  data-excise_duty_value_field="excise_duty_value"  data-excise_duty_type_field="excise_duty_type"  data-communications_tax_value_field="communications_tax_value"  data-communications_tax_type_field="communications_tax_type"  data-net_total_field="net_total" ', 'text'); 
                        ?>
                        
                    </div>
                    
        
                     

        </div>

         <div class="form-group" id="groupField_currency">
            <label for="currency" class="required col-form-label"> <?=lang('c4_invoice_item.currency'); ?></label>
            
                                    <?php

                           $currecyIcons = ['TRY' => 'fas fa-lira-sign', 'USD' => 'fas fa-dollar-sign', 'EUR' => 'fas fa-euro-sign', 'GBP' => 'fas fa-pound-sign'];
                           $lang_list = lang('c4_invoice_item.list_currency');

                           $selected = '';
                            if(!empty($lang_list))
                            {
                                $selected = $formData['currency'] ??  null;
                            }
                        ?>
                        <?php
                            //DO NOT allow change on edit mode. 
                            if(!empty($selected)){
                                $lang_list = [$selected => $lang_list[$selected]];            
                            }
                        ?>
                        <div class="input-group">
                            
                            <select name="currency"   id="currency" class="form-control selectpicker shadow-none" required maxlength="256" >   
                            <?php 
                               if(!empty($lang_list)){
                                    foreach($lang_list as $currency => $currency_text){
                                        $selected_text = ($selected === $currency) ? ' selected ' : ''; 
                                        $icon = $currecyIcons[$currency] ?? NULL;
                                        echo '<option value="'. $currency.'" data-icon="' . $icon. '" '. $selected_text. '>' . $currency_text .'</option>';
                                    }
                                 }
                            ?>  
                           </select>
                                
                               
                        </div>

        </div>

         <div class="form-group" id="groupField_vat_rate">
            <label for="vat_rate" class="required col-form-label"> <?=lang('c4_invoice_item.vat_rate'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_dropdown("vat_rate", lang('c4_invoice_item.list_vat_rate'), $formData['vat_rate'] ?? '18', '  id="vat_rate" class="form-control" required maxlength="15" '); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_discount_type">
            <label for="discount_type" class="required col-form-label"> <?=lang('c4_invoice_item.discount_type'); ?></label>
            
            
                <?php 
                    $lang_options = lang('c4_invoice_item.list_discount_type');
                    $p_array = isset($formData['discount_type']) ? explode(',', $formData['discount_type']) : [];
                        
                    if(!isset($formData['discount_type'])){
                        $p_array = ['percentage'];
                    }
                ?>
                <div class="">
                    <div class="form-check form-check-inline mt-2 mb-1" for="discount_typepercentage">
                        <?=form_radio("discount_type", 'percentage', in_array('percentage', $p_array), 'id="discount_typepercentage"  class="form-check-input" ');?>
                        <label class="form-check-label" for="discount_typepercentage"><?=$lang_options['percentage'] ?? 'percentage';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="discount_typeamount">
                        <?=form_radio("discount_type", 'amount', in_array('amount', $p_array), 'id="discount_typeamount"  class="form-check-input" ');?>
                        <label class="form-check-label" for="discount_typeamount"><?=$lang_options['amount'] ?? 'amount';?></label>
                    </div>
                </div>
                

        </div>

         <div class="form-group" id="groupField_discount_value">
            <label for="discount_value" class="required col-form-label"> <?=lang('c4_invoice_item.discount_value'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("discount_value", $formData['discount_value'] ?? '0.0000', ' id="discount_value" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_excise_duty_type">
            <label for="excise_duty_type" class="required col-form-label"> <?=lang('c4_invoice_item.excise_duty_type'); ?></label>
            
            
                <?php 
                    $lang_options = lang('c4_invoice_item.list_excise_duty_type');
                    $p_array = isset($formData['excise_duty_type']) ? explode(',', $formData['excise_duty_type']) : [];
                        
                    if(!isset($formData['excise_duty_type'])){
                        $p_array = ['percentage'];
                    }
                ?>
                <div class="">
                    <div class="form-check form-check-inline mt-2 mb-1" for="excise_duty_typepercentage">
                        <?=form_radio("excise_duty_type", 'percentage', in_array('percentage', $p_array), 'id="excise_duty_typepercentage"  class="form-check-input" ');?>
                        <label class="form-check-label" for="excise_duty_typepercentage"><?=$lang_options['percentage'] ?? 'percentage';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="excise_duty_typeamount">
                        <?=form_radio("excise_duty_type", 'amount', in_array('amount', $p_array), 'id="excise_duty_typeamount"  class="form-check-input" ');?>
                        <label class="form-check-label" for="excise_duty_typeamount"><?=$lang_options['amount'] ?? 'amount';?></label>
                    </div>
                </div>
                

        </div>

         <div class="form-group" id="groupField_excise_duty_value">
            <label for="excise_duty_value" class="required col-form-label"> <?=lang('c4_invoice_item.excise_duty_value'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("excise_duty_value", $formData['excise_duty_value'] ?? '0.0000', ' id="excise_duty_value" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_communications_tax_type">
            <label for="communications_tax_type" class="required col-form-label"> <?=lang('c4_invoice_item.communications_tax_type'); ?></label>
            
            
                <?php 
                    $lang_options = lang('c4_invoice_item.list_communications_tax_type');
                    $p_array = isset($formData['communications_tax_type']) ? explode(',', $formData['communications_tax_type']) : [];
                        
                    if(!isset($formData['communications_tax_type'])){
                        $p_array = ['percentage'];
                    }
                ?>
                <div class="">
                    <div class="form-check form-check-inline mt-2 mb-1" for="communications_tax_typepercentage">
                        <?=form_radio("communications_tax_type", 'percentage', in_array('percentage', $p_array), 'id="communications_tax_typepercentage"  class="form-check-input" ');?>
                        <label class="form-check-label" for="communications_tax_typepercentage"><?=$lang_options['percentage'] ?? 'percentage';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="communications_tax_typeamount">
                        <?=form_radio("communications_tax_type", 'amount', in_array('amount', $p_array), 'id="communications_tax_typeamount"  class="form-check-input" ');?>
                        <label class="form-check-label" for="communications_tax_typeamount"><?=$lang_options['amount'] ?? 'amount';?></label>
                    </div>
                </div>
                

        </div>

         <div class="form-group" id="groupField_communications_tax_value">
            <label for="communications_tax_value" class="required col-form-label"> <?=lang('c4_invoice_item.communications_tax_value'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("communications_tax_value", $formData['communications_tax_value'] ?? '0.0000', ' id="communications_tax_value" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_net_total">
            <label for="net_total" class="required col-form-label"> <?=lang('c4_invoice_item.net_total'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("net_total", $formData['net_total'] ?? '', ' id="net_total" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_description">
            <label for="description" class="required col-form-label"> <?=lang('c4_invoice_item.description'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"description", 'rows' => '3'], $formData['description'] ?? '', ' id="description" data-provide="" class="form-control selectpicker" required   rows="3"'); ?>   
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_unit_of_measure">
            <label for="unit_of_measure" class="required col-form-label"> <?=lang('c4_invoice_item.unit_of_measure'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("unit_of_measure", $formData['unit_of_measure'] ?? '', '  id="unit_of_measure" class="form-control" required maxlength="256" ', 'text'); 
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