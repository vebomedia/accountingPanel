<?php

$url = financepanel_url('c4_account/save/bank_account');
$hiddenArray = [];

if( !empty($formData['c4_account_id']) )
{
    $url .= '/' . $formData['c4_account_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="bank_account" autocomplete="off" role="presentation" data-pageslug="c4_account" data-formslug="bank_account"  data-jsname="c4_account" data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("account_type", $formData['account_type'] ?? "bank", '', 'hidden');?> 
<?=form_input("_formSlug", $formData['_formSlug'] ?? "bank_account", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "c4_account", '', 'hidden');?> 
<?=form_input("c4_account_id", $formData['c4_account_id'] ?? "", '', 'hidden');?> 
<?=form_input("account_type", 'bank', '', 'hidden');?>

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-university"></i> <?=lang('c4_account._form_bank_account'); ?> </h5>
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

         <div class="form-group" id="groupField_name">
            <label for="name" class="required col-form-label"> <?=lang('c4_account.name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("name", $formData['name'] ?? '', '  id="name" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>



                    <hr/>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_bank_name">
            <label for="bank_name" class="permit_empty col-form-label"> <?=lang('c4_account.bank_name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("bank_name", $formData['bank_name'] ?? '', '  id="bank_name" class="form-control" permit_empty maxlength="11" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_bank_branch">
            <label for="bank_branch" class="permit_empty col-form-label"> <?=lang('c4_account.bank_branch'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("bank_branch", $formData['bank_branch'] ?? '', '  id="bank_branch" class="form-control" permit_empty maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_bank_account_no">
            <label for="bank_account_no" class="permit_empty col-form-label"> <?=lang('c4_account.bank_account_no'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("bank_account_no", $formData['bank_account_no'] ?? '', '  id="bank_account_no" class="form-control" permit_empty maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_iban">
            <label for="iban" class="permit_empty col-form-label"> <?=lang('c4_account.iban'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("iban", $formData['iban'] ?? '', '  id="iban" class="form-control" permit_empty maxlength="255" ', 'text'); 
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