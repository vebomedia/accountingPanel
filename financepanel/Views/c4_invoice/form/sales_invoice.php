<?php

$url = financepanel_url('c4_invoice/save/sales_invoice');
$hiddenArray = [];

if( !empty($formData['c4_invoice_id']) )
{
    $url .= '/' . $formData['c4_invoice_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="sales_invoice" autocomplete="off" role="presentation" data-pageslug="sales_invoice" data-formslug="sales_invoice"  data-jsname="sales_invoice" data-modalsize="lg" data-packagelist="selectpicker,popover,select2_js,datepicker,input_number,INVOICE_ITEM_CALCULATION" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("invoice_type", $formData['invoice_type'] ?? "sales_invoice", '', 'hidden');?> 
<?=form_input("_formSlug", $formData['_formSlug'] ?? "sales_invoice", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "sales_invoice", '', 'hidden');?> 
<?=form_input("c4_invoice_id", $formData['c4_invoice_id'] ?? "", '', 'hidden');?> 
<?=form_input("invoice_type", 'sales_invoice', '', 'hidden');?>

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-file-invoice"></i> <?=lang('c4_invoice._form_sales_invoice'); ?> </h5>
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
            <label for="description" class="required col-form-label"> <?=lang('c4_invoice.description'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("description", $formData['description'] ?? '', '  id="description" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_contact_id">
            <label for="contact_id" class="required col-form-label"> <?=lang('c4_invoice.contact_id'); ?></label>
            
            
                    <?php
                        $option = [''=>'']; //[] cause select2js bug..
                        if(!empty($formData['contact_id']))
                        {
                            $query_result =  getContact(['contact_id'=>$formData['contact_id']]);

                            if(!empty($query_result))
                            {
                                $option = [$query_result['contact_id'] =>  $query_result['name']];
                            }
                        }
                    ?>
                    <div class="input-group">
                        
                        <?php echo form_dropdown("contact_id", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. financepanel_url('c4_invoice/getAllContact') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="sales_invoice"
      data-rprimarykey="contact_id" data-getrelationurl="c4_invoice/getAllContact"
      data-rkeyfield="contact_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="contact_id7319" data-newinputname="new_contact_id""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {contact_id}"    data-tags="true" data-relationformid="contact" 
'); ?>
                        
                                        <div data-createbutton="contact_id7319" style="display: none;">        
                    <a class="btn btn-sm btn-light btn-block" 
                        href="<?=financepanel_url('contact/showForm/contact');?>"
                            data-modalsize="lg"
                            data-modalurl="<?=financepanel_url('contact/showForm/contact');?>"
                            data-modaldata=""
                            data-modalview="centermodal" 
                            data-modalbackdrop="true"
                            data-select2id="contact_id7319"
                            data-relationformid="contact"
                            data-formid="sales_invoice"
                            data-filter=""
                            data-action="openselect2modal">
                        <span>
                            <i class="far fa-building"></i>
                            <span><?=lang('contact._form_contact');?></span>
                        </span>
                    </a>
                </div>
    
                    </div>

                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_issue_date">
            <label for="issue_date" class="required col-form-label"> <?=lang('c4_invoice.issue_date'); ?></label>
            
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
        </div>
        <div class="col">

         <div class="form-group" id="groupField_due_date">
            <label for="due_date" class="required col-form-label"> <?=lang('c4_invoice.due_date'); ?></label>
            
                            <?php 
                    if(!isset($formData['due_date'])){
                        $formData['due_date'] = date('Y-m-d');
                    }
                ?>
                    <div class="input-group date">
                        
                        <?php
                        echo form_input("due_date", $formData['due_date'] ?? '', ' id="due_date" class="form-control datepicker" required  ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_invoice_series">
            <label for="invoice_series" class="permit_empty col-form-label"> <?=lang('c4_invoice.invoice_series'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("invoice_series", $formData['invoice_series'] ?? '', '  id="invoice_series" class="form-control" permit_empty maxlength="50" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_invoice_number">
            <label for="invoice_number" class="permit_empty col-form-label"> <?=lang('c4_invoice.invoice_number'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("invoice_number", $formData['invoice_number'] ?? '', '  id="invoice_number" class="form-control" permit_empty maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">
        </div>
        <div class="col">

         <div class="form-group" id="groupField_gross_total">
            <label for="gross_total" class="required col-form-label"> <?=lang('c4_invoice.gross_total'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("gross_total", $formData['gross_total'] ?? '0.0000', ' id="gross_total" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_total_vat">
            <label for="total_vat" class="required col-form-label"> <?=lang('c4_invoice.total_vat'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("total_vat", $formData['total_vat'] ?? '0.0000', ' id="total_vat" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>

         <div class="form-group" id="groupField_net_total">
            <label for="net_total" class="required col-form-label"> <?=lang('c4_invoice.net_total'); ?></label>
            
                            <div class="input-group">
                    
                    <?php echo form_input("net_total", $formData['net_total'] ?? '0.0000', ' id="net_total" class="form-control input_number" required maxlength="15" '); ?> 
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


    <div class="sales_invoice_relation_c4_invoice_item">
        <div class="form-row label_sales_invoice_relation_c4_invoice_item p-1 mb-2" style="background: #f4f3f8;">
            <!-- product_id -->
            <div class="form-group col"><?=lang('c4_invoice_item.product_id');?></div>

            <!-- name -->
            <div class="form-group col"><?=lang('c4_invoice_item.name');?></div>

            <!-- unit_price -->
            <div class="form-group col"><?=lang('c4_invoice_item.unit_price');?></div>

            <!-- quantity -->
            <div class="form-group col"><?=lang('c4_invoice_item.quantity');?></div>

            <!-- vat_rate -->
            <div class="form-group col"><?=lang('c4_invoice_item.vat_rate');?></div>

            <!-- net_total -->
            <div class="form-group col"><?=lang('c4_invoice_item.net_total');?></div>
            <div class="form-group col-sm-1 delete-row"></div>
        </div>
        <!-- ----------------------START SUBFORM c4_invoice_item ---------------  -->        
        <?php

        $getAllC4_invoice_item = [];

        if( !empty($formData['c4_invoice_id']) ) {

            $getAllC4_invoice_item = getAllC4_invoice_item(['c4_invoice_id' => $formData['c4_invoice_id']]);

        }

        if(!empty($getAllC4_invoice_item))
        {
            foreach ($getAllC4_invoice_item as $key => $formData):

                    echo financepanel_view('c4_invoice/form/sales_invoice_relation_c4_invoice_item', ['key' => $formData['c4_invoice_item_id'] ?? null, 'formData' => $formData]);

            endforeach;
        }
        else
        {
            echo financepanel_view('c4_invoice/form/sales_invoice_relation_c4_invoice_item', ['key' => rand(100000000, 900000000), 'formData' => null]);
        }
        ?>

    </div>
         <button type="button" class="btn btn-secondary btn-lg btn-block mt-1 new_sales_invoice_relation_c4_invoice_item"><span>+ <?=lang('home.new'); ?>  <?=lang('c4_invoice_item._page_c4_invoice_item'); ?></span></button>
                
    <!-- ----------------------/END SUB FORM c4_invoice_item ------------------------------------  -->            















</div>

<div class="modal-footer">
    
    
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('home.dismiss');?></button>
    <button type="submit" class="btn btn-primary"><?=lang('home.save');?></button>
</div>

<?php echo form_close(); ?>