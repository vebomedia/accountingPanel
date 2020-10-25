<?php

$url = financepanel_url('c4_shipment_document/save/inflow_shipment_document');
$hiddenArray = [];

if( !empty($formData['c4_shipment_document_id']) )
{
    $url .= '/' . $formData['c4_shipment_document_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="inflow_shipment_document" autocomplete="off" role="presentation" data-pageslug="inflow_shipment_document" data-formslug="inflow_shipment_document"  data-jsname="inflow_shipment_document" data-modalsize="lg" data-packagelist="selectpicker,popover,datepicker,datetimepicker" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("inflow", $formData['inflow'] ?? "1", '', 'hidden');?> 
<?=form_input("_formSlug", $formData['_formSlug'] ?? "inflow_shipment_document", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "inflow_shipment_document", '', 'hidden');?> 
<?=form_input("c4_shipment_document_id", $formData['c4_shipment_document_id'] ?? "", '', 'hidden');?> 
<?=form_input("inflow", '1', '', 'hidden');?>

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-shipping-fast"></i> <?=lang('c4_shipment_document._form_inflow_shipment_document'); ?> </h5>
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

         <div class="form-group" id="groupField_description">
            <label for="description" class="required col-form-label"> <?=lang('c4_shipment_document.description'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("description", $formData['description'] ?? '', '  id="description" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_address">
            <label for="address" class="required col-form-label"> <?=lang('c4_shipment_document.address'); ?></label>
            
            
                    <div class="input-group">
                        
                        <?php echo form_textarea(['name'=>"address", 'rows' => '3'], $formData['address'] ?? '', ' id="address" data-provide="" class="form-control selectpicker" required   rows="3"'); ?>   
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_issue_date">
            <label for="issue_date" class="required col-form-label"> <?=lang('c4_shipment_document.issue_date'); ?></label>
            
                            <?php 
                    if(!isset($formData['issue_date'])){
                        $formData['issue_date'] = date('Y-m-d');
                    }
                ?>
                    <div class="input-group date">
                        
                        <?php
                        echo form_input("issue_date", $formData['issue_date'] ?? '', ' id="issue_date" class="form-control datepicker" required  ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_shipment_date">
            <label for="shipment_date" class="required col-form-label"> <?=lang('c4_shipment_document.shipment_date'); ?></label>
            
            
                    <div class="input-group date">
                        
                        <?php
                        echo form_input("shipment_date", $formData['shipment_date'] ?? '', ' id="shipment_date" class="form-control datetimepicker" required  ', 'text'); 
                        ?>
                        
                    </div>
                    
        </div>

         <div class="form-group" id="groupField_procurement_number">
            <label for="procurement_number" class="required col-form-label"> <?=lang('c4_shipment_document.procurement_number'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("procurement_number", $formData['procurement_number'] ?? '', '  id="procurement_number" class="form-control" required maxlength="255" ', 'text'); 
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