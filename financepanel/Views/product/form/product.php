<?php

$url = financepanel_url('product/save/product');
$hiddenArray = [];

if( !empty($formData['product_id']) )
{
    $url .= '/' . $formData['product_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="product" autocomplete="off" role="presentation" data-pageslug="product" data-formslug="product"  data-jsname="product" data-modalsize="lg" data-packagelist="selectpicker,popover,uisortable,cropperjs,checkAndShow,input_number" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "product", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "product", '', 'hidden');?> 
<?=form_input("product_id", $formData['product_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-tags"></i> <?=lang('product._form_product'); ?> </h5>
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

            <div class="form-group row" id="groupField_name">
                <label for="name" class="required col-sm-4 col-form-label"> <?=lang('product.name'); ?></label>
                <div class="col-sm-8">
                                        <div class="input-group">
                        
                        <?php
                        echo form_input("name", $formData['name'] ?? '', ' id="name" class="form-control" required maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

                </div>
            </div>
        </div>
        <div class="col">

            <div class="form-group row" id="groupField_photo">
                <label for="photo" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.photo'); ?></label>
                <div class="col-sm-8">
                    
<div class="input-group">
    <?php
    $def = resources_url('images/empty.png');
    $randomID = rand(10000, 99999);

    if (!empty($formData['photo']))
    {
        $fileService = \Financepanel\Config\Services::file();
        $file = $fileService->getFile($formData['photo']);

        if (!empty($file))
        {
            // $def = getThumbFromData($file);
            $def = $file['url_thumb'];
        }
    }

    ?>

    <label class="label labelcropper" data-toggle="tooltip" title="<?=lang("product.photo_helpText")?>" style="cursor: pointer;">
        <img class="rounded cropper_img img-thumbnail float-left" id="cropper_img_<?=$randomID;?>" src="<?=$def;?>" alt="avatar" style="max-width: 90px;"/>
        <input type="file" name="file" accept="image/*" class="sr-only cropperjs" id="input_<?=$randomID;?>" 
            data-action="<?=financepanel_url("product/uploadFile/product/photo");?>" data-inputname="photo" data-idnumber="<?=$randomID;?>" 
            data-isrounded="" data-maxw="600" data-maxh="600" 
           data-minw="600" data-minh="600" data-fixedcropbox="1">
    </label>
   
    <?php echo form_input("photo", $formData['photo'] ?? '', '', 'hidden'); ?>

</div>

<div class="progress cropper_progress" id="progress_<?=$randomID;?>" style="display:none">
    <div id="progressbar_<?=$randomID;?>" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
</div>

                </div>
            </div>
        </div>
    </div>



                    <hr/>

    

    <div class="form-row">
        <div class="col">

            <div class="form-group row" id="groupField_code">
                <label for="code" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.code'); ?></label>
                <div class="col-sm-8">
                                        <div class="input-group">
                        
                        <?php
                        echo form_input("code", $formData['code'] ?? '', '  id="code" class="form-control" permit_empty maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

                </div>
            </div>
        </div>
        <div class="col">

            <div class="form-group row" id="groupField_barcode">
                <label for="barcode" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.barcode'); ?></label>
                <div class="col-sm-8">
                                        <div class="input-group">
                        
                        <?php
                        echo form_input("barcode", $formData['barcode'] ?? '', '  id="barcode" class="form-control" permit_empty maxlength="255" ', 'text'); 
                        ?>
                        
                    </div>
                    

                </div>
            </div>
        </div>
    </div>



                    <hr/>

    

    <div class="form-row">
        <div class="col">

            <div class="form-group row" id="groupField_inventory_tracking">
                <label for="inventory_tracking" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.inventory_tracking'); ?></label>
                <div class="col-sm-8">
                     
<div class="">
                        <div class="form-check mt-2 mb-4" for="inventory_tracking">
                            <?php
                            $checked = $formData['inventory_tracking'] ?? '1';    
                            echo form_checkbox("inventory_tracking", '1', $checked,  ' id="inventory_tracking" class="form-check-input checkAndShow" permit_empty maxlength="1"  data-toogleids="initial_stock_count,critical_stock_alert"');?>
                            <label class="form-check-label" for="inventory_tracking"></label>
                        </div>
                        
                    </div>
                    

                </div>
            </div>

            <div class="form-group row" id="groupField_initial_stock_count">
                <label for="initial_stock_count" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.initial_stock_count'); ?></label>
                <div class="col-sm-8">
                                        <div class="input-group">
                        
                        <?php
                        echo form_input("initial_stock_count", $formData['initial_stock_count'] ?? '0', ' id="initial_stock_count" class="form-control input_number" permit_empty  ', 'text'); 
                        ?>
                        
                    </div>
                    

                </div>
            </div>
        </div>
        <div class="col">

            <div class="form-group row" id="groupField_critical_stock_alert">
                <label for="critical_stock_alert" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.critical_stock_alert'); ?></label>
                <div class="col-sm-8">
                     
<div class="">
                        <div class="form-check mt-2 mb-4" for="critical_stock_alert">
                            <?php
                            $checked = $formData['critical_stock_alert'] ?? '0';    
                            echo form_checkbox("critical_stock_alert", '1', $checked,  ' id="critical_stock_alert" class="form-check-input checkAndShow" permit_empty maxlength="1"  data-toogleids="critical_stock_count"');?>
                            <label class="form-check-label" for="critical_stock_alert"></label>
                        </div>
                        
                    </div>
                    

                </div>
            </div>

            <div class="form-group row" id="groupField_critical_stock_count">
                <label for="critical_stock_count" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.critical_stock_count'); ?></label>
                <div class="col-sm-8">
                                        <div class="input-group">
                        
                        <?php
                        echo form_input("critical_stock_count", $formData['critical_stock_count'] ?? '0.0000', ' id="critical_stock_count" class="form-control input_number" permit_empty maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

                </div>
            </div>
        </div>
    </div>



                    <hr/>

    

    <div class="form-row">
        <div class="col">

            <div class="form-group row" id="groupField_buying_price">
                <label for="buying_price" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.buying_price'); ?></label>
                <div class="col-sm-8">
                                    <div class="input-group">
                    
                    <?php echo form_input("buying_price", $formData['buying_price'] ?? '0.0000', ' id="buying_price" class="form-control input_number" permit_empty maxlength="15" '); ?> 
                    <?php
                        $currecyIcons = ['TRY' => 'fas fa-lira-sign', 'USD' => 'fas fa-dollar-sign', 'EUR' => 'fas fa-euro-sign', 'GBP' => 'fas fa-pound-sign'];  
                        $selected = $formData['buying_currency'] ??  'TRY';
                    ?>                        <?php
                            //DO NOT allow change on edit mode. 
                            if(!empty($formData['buying_currency'])){
                                $currecyIcons = [$selected => $currecyIcons[$selected]];            
                            }
                        ?>
                    <select name="buying_currency" id="" class="currency_buying_currency selectpicker shadow-none" data-width="60px">
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
        <div class="col">

            <div class="form-group row" id="groupField_list_price">
                <label for="list_price" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.list_price'); ?></label>
                <div class="col-sm-8">
                                    <div class="input-group">
                    
                    <?php echo form_input("list_price", $formData['list_price'] ?? '0.0000', ' id="list_price" class="form-control input_number" permit_empty maxlength="15" '); ?> 
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
    </div>



                    <hr/>

    

    <div class="form-row">
        <div class="col">

            <div class="form-group row" id="groupField_vat_rate">
                <label for="vat_rate" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.vat_rate'); ?></label>
                <div class="col-sm-8">
                                        <div class="input-group">
                        
                        <?php
                        echo form_dropdown("vat_rate", lang('product.list_vat_rate'), $formData['vat_rate'] ?? '18.0000', '  id="vat_rate" class="form-control" permit_empty maxlength="15" '); 
                        ?>
                        
                    </div>
                    

                </div>
            </div>

            <div class="form-group row" id="groupField_communications_tax">
                <label for="communications_tax" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.communications_tax'); ?></label>
                <div class="col-sm-8">
                    
                    <div class="input-group">
                            
                       <?php echo form_input("communications_tax", $formData['communications_tax'] ?? '0.0000', 'class="form-control input_number"'); ?> 
                       <?php
                        $currecyIcons = ['TRY' => 'fas fa-lira-sign', 'USD'=>'fas fa-dollar-sign', 'EUR'=>'fas fa-euro-sign', 'GBP'=>'fas fa-pound-sign'];  
                        ?>
                        <select name="communications_tax_type"  id="communications_tax_type" class="selectpicker  shadow-none" data-width="60px" onchange="">
                            <?php
                            $selected = $formData['communications_tax_type'] ??  null;
        
                            $selected_text = ($selected === 'percentage') ? ' selected ' : '';
                            $icon = 'fas fa-percent';
                            echo '<option value="percentage" data-icon="' . $icon. '" '. $selected_text. '></option>';
       
                            $selected_text = ($selected === 'amount') ? ' selected ' : ''; 
                            $currency = $formData['currency'] ?? 'TRY';
                            $icon = $currecyIcons[$currency] ?? 'TRY';

                            echo '<option value="amount" data-icon="' . $icon. '" '. $selected_text. '></option>';
                          
                            ?>      
                        </select>
                    </div>

    
                </div>
            </div>

            <div class="form-group row" id="groupField_purchase_excise_duty">
                <label for="purchase_excise_duty" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.purchase_excise_duty'); ?></label>
                <div class="col-sm-8">
                    
                    <div class="input-group">
                            
                       <?php echo form_input("purchase_excise_duty", $formData['purchase_excise_duty'] ?? '0.0000', 'class="form-control input_number"'); ?> 
                       <?php
                        $currecyIcons = ['TRY' => 'fas fa-lira-sign', 'USD'=>'fas fa-dollar-sign', 'EUR'=>'fas fa-euro-sign', 'GBP'=>'fas fa-pound-sign'];  
                        ?>
                        <select name="purchase_excise_duty_type"  id="purchase_excise_duty_type" class="selectpicker  shadow-none" data-width="60px" onchange="">
                            <?php
                            $selected = $formData['purchase_excise_duty_type'] ??  null;
        
                            $selected_text = ($selected === 'percentage') ? ' selected ' : '';
                            $icon = 'fas fa-percent';
                            echo '<option value="percentage" data-icon="' . $icon. '" '. $selected_text. '></option>';
       
                            $selected_text = ($selected === 'amount') ? ' selected ' : ''; 
                            $currency = $formData['buying_currency'] ?? 'TRY';
                            $icon = $currecyIcons[$currency] ?? 'TRY';

                            echo '<option value="amount" data-icon="' . $icon. '" '. $selected_text. '></option>';
                          
                            ?>      
                        </select>
                    </div>

    
                </div>
            </div>

            <div class="form-group row" id="groupField_sales_excise_duty">
                <label for="sales_excise_duty" class="permit_empty col-sm-4 col-form-label"> <?=lang('product.sales_excise_duty'); ?></label>
                <div class="col-sm-8">
                    
                    <div class="input-group">
                            
                       <?php echo form_input("sales_excise_duty", $formData['sales_excise_duty'] ?? '', 'class="form-control input_number"'); ?> 
                       <?php
                        $currecyIcons = ['TRY' => 'fas fa-lira-sign', 'USD'=>'fas fa-dollar-sign', 'EUR'=>'fas fa-euro-sign', 'GBP'=>'fas fa-pound-sign'];  
                        ?>
                        <select name="sales_excise_duty_type"  id="sales_excise_duty_type" class="selectpicker  shadow-none" data-width="60px" onchange="">
                            <?php
                            $selected = $formData['sales_excise_duty_type'] ??  null;
        
                            $selected_text = ($selected === 'percentage') ? ' selected ' : '';
                            $icon = 'fas fa-percent';
                            echo '<option value="percentage" data-icon="' . $icon. '" '. $selected_text. '></option>';
       
                            $selected_text = ($selected === 'amount') ? ' selected ' : ''; 
                            $currency = $formData['currency'] ?? 'TRY';
                            $icon = $currecyIcons[$currency] ?? 'TRY';

                            echo '<option value="amount" data-icon="' . $icon. '" '. $selected_text. '></option>';
                          
                            ?>      
                        </select>
                    </div>

    
                </div>
            </div>
        </div>
        <div class="col">
        </div>
    </div>

















</div>

<div class="modal-footer">
    
    
    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=lang('home.dismiss');?></button>
    <button type="submit" class="btn btn-primary"><?=lang('home.save');?></button>
</div>

<?php echo form_close(); ?>