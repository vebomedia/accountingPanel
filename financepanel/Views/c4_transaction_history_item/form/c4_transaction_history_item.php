<?php

$url = financepanel_url('c4_transaction_history_item/save/c4_transaction_history_item');
$hiddenArray = [];

if( !empty($formData['c4_transaction_history_item_id']) )
{
    $url .= '/' . $formData['c4_transaction_history_item_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="c4_transaction_history_item" autocomplete="off" role="presentation" data-pageslug="c4_transaction_history_item" data-formslug="c4_transaction_history_item"  data-jsname="c4_transaction_history_item" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js,input_number" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "c4_transaction_history_item", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_transaction_history_item", '', 'hidden');?> 
<?=form_input("c4_transaction_history_item_id", $formData['c4_transaction_history_item_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-money-bill-wave-alt"></i> <?=lang('c4_transaction_history_item._form_c4_transaction_history_item'); ?> </h5>
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

         <div class="form-group" id="groupField_c4_transaction_id">
            <label for="c4_transaction_id" class="required col-form-label"> <?=lang('c4_transaction_history_item.c4_transaction_id'); ?></label>
            
            
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
                    <div class="input-group">
                        
                        <?php echo form_dropdown("c4_transaction_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. financepanel_url('c4_transaction_history_item/getAllC4_transaction') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="c4_transaction_history_item"
      data-rprimarykey="c4_transaction_id" data-getrelationurl="c4_transaction_history_item/getAllC4_transaction"
      data-rkeyfield="c4_transaction_id" data-rvaluefield="transaction_type" data-rvaluefield2=""
      data-required ="required" id="c4_transaction_id6868" data-newinputname="new_c4_transaction_id""
      data-optionview="{transaction_type}" data-selectedview="{transaction_type}"  data-titleview="ID: {c4_transaction_id}"'); ?>
                        
                            
                    </div>

                    

        </div>

         <div class="form-group" id="groupField_eur_balance">
            <label for="eur_balance" class="required col-form-label"> <?=lang('c4_transaction_history_item.eur_balance'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("eur_balance", $formData['eur_balance'] ?? '0.0000', ' id="eur_balance" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_gbp_balance">
            <label for="gbp_balance" class="required col-form-label"> <?=lang('c4_transaction_history_item.gbp_balance'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("gbp_balance", $formData['gbp_balance'] ?? '0.0000', ' id="gbp_balance" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_try_balance">
            <label for="try_balance" class="required col-form-label"> <?=lang('c4_transaction_history_item.try_balance'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("try_balance", $formData['try_balance'] ?? '0.0000', ' id="try_balance" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_usd_balance">
            <label for="usd_balance" class="required col-form-label"> <?=lang('c4_transaction_history_item.usd_balance'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("usd_balance", $formData['usd_balance'] ?? '0.0000', ' id="usd_balance" class="form-control input_number" required maxlength="15" ', 'text'); 
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