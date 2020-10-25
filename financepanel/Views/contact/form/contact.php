<?php

$url = financepanel_url('contact/save/contact');
$hiddenArray = [];

if( !empty($formData['contact_id']) )
{
    $url .= '/' . $formData['contact_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="contact" autocomplete="off" role="presentation" data-pageslug="contact" data-formslug="contact"  data-jsname="contact" data-modalsize="lg" data-packagelist="selectpicker,popover" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "contact", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "contact", '', 'hidden');?> 
<?=form_input("contact_id", $formData['contact_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="far fa-building"></i> <?=lang('contact._form_contact'); ?> </h5>
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
            <label for="name" class="required col-form-label"> <?=lang('contact.name'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("name", $formData['name'] ?? '', '  id="name" class="form-control" required  ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_contact_type">
            <label for="contact_type" class="required col-form-label"> <?=lang('contact.contact_type'); ?></label>
            
            
                <?php 
                    $lang_options = lang('contact.list_contact_type');
                    $p_array = isset($formData['contact_type']) ? explode(',', $formData['contact_type']) : [];
                        
                    if(!isset($formData['contact_type'])){
                        $p_array = ['customer'];
                    }
                ?>
                <div class="">
                    <div class="form-check form-check-inline mt-2 mb-1" for="contact_typecompany">
                        <?=form_radio("contact_type", 'company', in_array('company', $p_array), 'id="contact_typecompany"  class="form-check-input" ');?>
                        <label class="form-check-label" for="contact_typecompany"><?=$lang_options['company'] ?? 'company';?></label>
                    </div>
                    <div class="form-check form-check-inline mt-2 mb-1" for="contact_typeperson">
                        <?=form_radio("contact_type", 'person', in_array('person', $p_array), 'id="contact_typeperson"  class="form-check-input" ');?>
                        <label class="form-check-label" for="contact_typeperson"><?=$lang_options['person'] ?? 'person';?></label>
                    </div>
                </div>
                

        </div>

         <div class="form-group" id="groupField_phone">
            <label for="phone" class="permit_empty col-form-label"> <?=lang('contact.phone'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("phone", $formData['phone'] ?? '', ' id="phone" class="form-control" permit_empty maxlength="255" ', 'phone'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_email">
            <label for="email" class="permit_empty col-form-label"> <?=lang('contact.email'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("email", $formData['email'] ?? '', ' id="email" class="form-control" permit_empty maxlength="255" ', 'email'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_iban">
            <label for="iban" class="permit_empty col-form-label"> <?=lang('contact.iban'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("iban", $formData['iban'] ?? '', '  id="iban" class="form-control" permit_empty maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_fax">
            <label for="fax" class="permit_empty col-form-label"> <?=lang('contact.fax'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("fax", $formData['fax'] ?? '', '  id="fax" class="form-control" permit_empty maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_address">
            <label for="address" class="permit_empty col-form-label"> <?=lang('contact.address'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("address", $formData['address'] ?? '', '  id="address" class="form-control" permit_empty maxlength="255" ', 'text'); 
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