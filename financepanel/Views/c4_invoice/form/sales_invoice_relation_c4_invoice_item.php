
        <!-- ----------------------/Start SUB FORM c4_invoice_item ------------------------------------  -->     
        
        <div class="form-row group_sales_invoice_relation_c4_invoice_item">

<?=form_input("c4_invoice_item[$key][c4_invoice_item_id]", $formData['c4_invoice_item_id'] ?? "", '', 'hidden');?> 
<?=form_input("c4_invoice_item[$key][c4_invoice_id]", $formData['c4_invoice_id'] ?? "", '', 'hidden');?> 
            <!-- product_id -->
            <div class="form-group col" id="groupField_<?="c4_invoice_item_{$key}_product_id";?>">

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
                        
                        <?php echo form_dropdown("c4_invoice_item[$key][product_id]", $option, '', ' class="form-control select2_js" 
      data-ajax--url="'. financepanel_url('c4_invoice_item/getAllProduct') . '" 
      data-placeholder="'. lang('home.select') . '" data-theme="bootstrap4" data-selectonclose="true"
      data-minimuminputlength="0" data-formname="sales_invoice"
      data-rprimarykey="product_id" data-getrelationurl="c4_invoice_item/getAllProduct"
      data-rkeyfield="product_id" data-rvaluefield="name" data-rvaluefield2=""
      data-required ="required" id="c4_invoice_item_' . $key .'_product_id1231" data-newinputname="c4_invoice_item[' . $key .'][new_product_id]""
      data-optionview="{name}" data-selectedview="{name}"  data-titleview="ID: {product_id}"    data-fillto="name as c4_invoice_item[' . $key .'][name],list_price as c4_invoice_item[' . $key .'][unit_price],vat_rate as c4_invoice_item[' . $key .'][vat_rate]"'); ?>
                        
                            
                    </div>

                    

            </div>

            <!-- name -->
            <div class="form-group col" id="groupField_<?="c4_invoice_item_{$key}_name";?>">
                    <div class="input-group">
                        
                        <?php
                        echo form_input("c4_invoice_item[$key][name]", $formData['name'] ?? '', '  id="c4_invoice_item_' . $key .'_name" class="form-control" required maxlength="256" ', 'text'); 
                        ?>
                        
                    </div>
                    

            </div>

            <!-- unit_price -->
            <div class="form-group col" id="groupField_<?="c4_invoice_item_{$key}_unit_price";?>">
                    <div class="input-group">
                        
                        <?php
                        echo form_input("c4_invoice_item[$key][unit_price]", $formData['unit_price'] ?? '', ' id="c4_invoice_item_' . $key .'_unit_price" class="form-control input_number INVOICE_ITEM_CALCULATION" required maxlength="15"  data-unit_price_field="c4_invoice_item[' . $key  . '][unit_price]"  data-quantity_field="c4_invoice_item[' . $key  . '][quantity]"  data-vat_rate_field="c4_invoice_item[' . $key  . '][vat_rate]"  data-discount_value_field="c4_invoice_item[' . $key  . '][discount_value]"  data-discount_type_field="c4_invoice_item[' . $key  . '][discount_type]"  data-excise_duty_value_field="c4_invoice_item[' . $key  . '][excise_duty_value]"  data-excise_duty_type_field="c4_invoice_item[' . $key  . '][excise_duty_type]"  data-communications_tax_value_field="c4_invoice_item[' . $key  . '][communications_tax_value]"  data-communications_tax_type_field="c4_invoice_item[' . $key  . '][communications_tax_type]"  data-net_total_field="c4_invoice_item[' . $key  . '][net_total]" ', 'text'); 
                        ?>
                        
                    </div>
                    
        
                     

            </div>

            <!-- quantity -->
            <div class="form-group col" id="groupField_<?="c4_invoice_item_{$key}_quantity";?>">
                    <div class="input-group">
                        
                        <?php
                        echo form_input("c4_invoice_item[$key][quantity]", $formData['quantity'] ?? '1.0000', ' id="c4_invoice_item_' . $key .'_quantity" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

            </div>

            <!-- vat_rate -->
            <div class="form-group col" id="groupField_<?="c4_invoice_item_{$key}_vat_rate";?>">
                    <div class="input-group">
                        
                        <?php
                        echo form_dropdown("c4_invoice_item[$key][vat_rate]", lang('c4_invoice_item.list_vat_rate'), $formData['vat_rate'] ?? '18', '  id="c4_invoice_item_' . $key .'_vat_rate" class="form-control" required maxlength="15" '); 
                        ?>
                        
                    </div>
                    

            </div>

            <!-- net_total -->
            <div class="form-group col" id="groupField_<?="c4_invoice_item_{$key}_net_total";?>">
                    <div class="input-group">
                        
                        <?php
                        echo form_input("c4_invoice_item[$key][net_total]", $formData['net_total'] ?? '', ' id="c4_invoice_item_' . $key .'_net_total" class="form-control input_number" required maxlength="15" ', 'text'); 
                        ?>
                        
                    </div>
                    

            </div>

            <div class="form-group mt-1 col-sm-1"><button type="button" class="btn btn-sm btn-danger delete_sales_invoice_relation_c4_invoice_item"><i class="fa fa-times"></i></button></div>
                        
        </div>

    <!-- ----------------------/END SUB FORM c4_invoice_item ------------------------------------  -->            