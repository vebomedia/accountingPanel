<?php

$url = financepanel_url('c4_transaction/save/money_out');
$hiddenArray = [];

if( !empty($formData['c4_transaction_id']) )
{
    $url .= '/' . $formData['c4_transaction_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="money_out" autocomplete="off" role="presentation" data-pageslug="c4_transaction" data-formslug="money_out"  data-jsname="c4_transaction" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js,datepicker,input_number" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("transaction_type", $formData['transaction_type'] ?? "account_credit", '', 'hidden');?> 
<?=form_input("_formSlug", $formData['_formSlug'] ?? "money_out", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_transaction", '', 'hidden');?> 
<?=form_input("c4_transaction_id", $formData['c4_transaction_id'] ?? "", '', 'hidden');?> 
<?=form_input("transaction_type", 'account_credit', '', 'hidden');?>

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="far fa-money-bill-alt"></i> <?=lang('c4_transaction._form_money_out'); ?> </h5>
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

         <div class="form-group" id="groupField_c4_account_id">
            <label for="c4_account_id" class="required col-form-label"> <?=lang('c4_transaction.c4_account_id'); ?></label>
            
            
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
      data-ajax--url="'. financepanel_url('c4_transaction/getAllC4_account') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="money_out"
      data-rprimarykey="c4_account_id" data-getrelationurl="c4_transaction/getAllC4_account"
      data-rkeyfield="c4_account_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="c4_account_id5369" data-newinputname="new_c4_account_id""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {c4_account_id}"'); ?>
                        
                            
                    </div>

                    

        </div>

         <div class="form-group" id="groupField_date">
            <label for="date" class="required col-form-label"> <?=lang('c4_transaction.date'); ?></label>
            
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

         <div class="form-group" id="groupField_credit_amount">
            <label for="credit_amount" class="required col-form-label"> <?=lang('c4_transaction.credit_amount'); ?></label>
            
                            <div class="input-group">
                    
                    <?php echo form_input("credit_amount", $formData['credit_amount'] ?? '0.0000', ' id="credit_amount" class="form-control input_number" required maxlength="15" '); ?> 
                    <?php
                        $currecyIcons = ['TRY' => 'fas fa-lira-sign', 'USD' => 'fas fa-dollar-sign', 'EUR' => 'fas fa-euro-sign', 'GBP' => 'fas fa-pound-sign'];  
                        $selected = $formData['credit_currency'] ??  'TRY';
                    ?>                        <?php
                            //DO NOT allow change on edit mode. 
                            if(!empty($formData['credit_currency'])){
                                $currecyIcons = [$selected => $currecyIcons[$selected]];            
                            }
                        ?>
                    <select name="credit_currency" id="" class="currency_credit_currency selectpicker shadow-none" data-width="60px">
                       <?php
                        foreach($currecyIcons as $currency => $currency_icon){

                            $selected_text = ($selected === $currency) ? ' selected ' : ''; 

                            echo '<option value="'. $currency.'" data-icon="' . $currency_icon. '" '. $selected_text. '></option>';
                        }
                        ?>
                    </select>
                </div>
            

        </div>

         <div class="form-group" id="groupField_description">
            <label for="description" class="permit_empty col-form-label"> <?=lang('c4_transaction.description'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("description", $formData['description'] ?? '', '  id="description" class="form-control" permit_empty maxlength="255" ', 'text'); 
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