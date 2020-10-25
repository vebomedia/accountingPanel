<?php

$url = financepanel_url('c4_payment/save/c4_payment');
$hiddenArray = [];

if( !empty($formData['c4_payment_id']) )
{
    $url .= '/' . $formData['c4_payment_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_payment" autocomplete="off" role="presentation" data-pageslug="c4_payment" data-formslug="c4_payment"  data-jsname="c4_payment" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js,datepicker,input_number" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_payment", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_payment", '', 'hidden');?> 
<?=form_input("c4_payment_id", $formData['c4_payment_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-money-bill"></i> <?=lang('c4_payment._form_c4_payment'); ?> </h5>
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
            <label for="c4_invoice_id" class="required col-form-label"> <?=lang('c4_payment.c4_invoice_id'); ?></label>
            
            
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
      data-ajax--url="'. financepanel_url('c4_payment/getAllC4_invoice') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="c4_payment"
      data-rprimarykey="c4_invoice_id" data-getrelationurl="c4_payment/getAllC4_invoice"
      data-rkeyfield="c4_invoice_id" data-rvaluefield="description" data-rvaluefield2=""
      data-required ="required" id="c4_invoice_id4110" data-newinputname="new_c4_invoice_id""
      data-optionview="{description}" data-selectedview="{description}"  data-titleview="ID: {c4_invoice_id}"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
        <div class="col">
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_c4_account_id">
            <label for="c4_account_id" class="required col-form-label"> <?=lang('c4_payment.c4_account_id'); ?></label>
            
            
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
                    <div class="input-group">
                        
                        <?php echo form_dropdown("c4_account_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. financepanel_url('c4_payment/getAllC4_account') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="c4_payment"
      data-rprimarykey="c4_account_id" data-getrelationurl="c4_payment/getAllC4_account"
      data-rkeyfield="c4_account_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="c4_account_id7463" data-newinputname="new_c4_account_id""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {c4_account_id}"'); ?>
                        
                            
                    </div>

                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_date">
            <label for="date" class="required col-form-label"> <?=lang('c4_payment.date'); ?></label>
            
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
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">
        </div>
        <div class="col">

         <div class="form-group" id="groupField_amount">
            <label for="amount" class="required col-form-label"> <?=lang('c4_payment.amount'); ?></label>
            
                            <div class="input-group">
                    
                    <?php echo form_input("amount", $formData['amount'] ?? '', ' id="amount" class="form-control input_number" required maxlength="15" '); ?> 
                    <?php
                        $currecyIcons = ['TRY' => 'fas fa-lira-sign', 'USD' => 'fas fa-dollar-sign', 'EUR' => 'fas fa-euro-sign', 'GBP' => 'fas fa-pound-sign'];  
                        $selected = $formData['currency'] ??  'TRY';
                    ?>                        <?php
                            //DO NOT allow change on edit mode. 
                            if(!empty($formData['currency'])){
                                $currecyIcons = [$selected => $currecyIcons[$selected]];            
                            }
                        ?>
                    <select name="currency" id="" class="currency_currency selectpicker shadow-none" data-width="60px">
                       <?php
                        foreach($currecyIcons as $currency => $currency_icon){

                            $selected_text = ($selected === $currency) ? ' selected ' : ''; 

                            echo '<option value="'. $currency.'" data-icon="' . $currency_icon. '" '. $selected_text. '></option>';
                        }
                        ?>
                    </select>
                </div>
            

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_notes">
            <label for="notes" class="permit_empty col-form-label"> <?=lang('c4_payment.notes'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"notes", 'rows' => '3'], $formData['notes'] ?? '', ' id="notes" data-provide="" class="form-control selectpicker" permit_empty   rows="3"'); ?>   
                        
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