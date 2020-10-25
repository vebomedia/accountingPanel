


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-shipping-fast"></i>
                    <span><?=lang('home._crud_c4_shipment_document');?> </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header"><?=lang('home._crud_c4_shipment_document');?> </h6>    

                    
            <a class="dropdown-item" href="<?=financepanel_url('c4_shipment_document/inflow_shipment_document');?>"><i class="fas fa-shipping-fast"></i> <?=lang('home._page_inflow_shipment_document');?> </a>

            <a class="dropdown-item" href="<?=financepanel_url('c4_shipment_document/outflow_shipment_document');?>"><i class="fas fa-ship"></i> <?=lang('home._page_outflow_shipment_document');?> </a>
 


                </div>
            </li>            
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=financepanel_url('c4_account/c4_account');?>">
                    <i class="fas fa-university"></i>
                    <span><?=lang('home._page_c4_account');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=financepanel_url('user/user');?>">
                    <i class="fas fa-user-alt"></i>
                    <span><?=lang('home._page_user');?></span>
                </a>
            </li>   
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=financepanel_url('product/product');?>">
                    <i class="fas fa-tags"></i>
                    <span><?=lang('home._page_product');?></span>
                </a>
            </li>   
            


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-file-invoice"></i>
                    <span><?=lang('home._crud_c4_invoice');?> </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header"><?=lang('home._crud_c4_invoice');?> </h6>    

                    
            <a class="dropdown-item" href="<?=financepanel_url('c4_invoice/sales_invoice');?>"><i class="fas fa-file-invoice"></i> <?=lang('home._page_sales_invoice');?> </a>

            <a class="dropdown-item" href="<?=financepanel_url('c4_invoice/purchase_invoice');?>"><i class="fas fa-file-invoice"></i> <?=lang('home._page_purchase_invoice');?> </a>

            <a class="dropdown-item" href="<?=financepanel_url('c4_invoice/showchart/sales_invoice_daily_statistic');?>"><i class="fas fa-chart-line"></i> <?=lang('home._chart_sales_invoice_daily_statistic');?> </a>

            <a class="dropdown-item" href="<?=financepanel_url('c4_invoice/showchart/purchase');?>"><i class="far fa-money-bill-alt"></i> <?=lang('home._chart_purchase');?> </a>
 


                </div>
            </li>            
                        
             <li class="nav-item">
                <a class="nav-link" href="<?=financepanel_url('contact/contact');?>">
                    <i class="far fa-building"></i>
                    <span><?=lang('home._page_contact');?></span>
                </a>
            </li>   
            


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-money-bill"></i>
                    <span><?=lang('home._crud_c4_payment');?> </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header"><?=lang('home._crud_c4_payment');?> </h6>    

                    
            <a class="dropdown-item" href="<?=financepanel_url('c4_payment/c4_payment');?>"><i class="fas fa-money-bill"></i> <?=lang('home._page_c4_payment');?> </a>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header"><?=lang('home._crud_c4_transaction');?> </h6>

            <a class="dropdown-item" href="<?=financepanel_url('c4_transaction/c4_transaction');?>"><i class="fas fa-money-bill-wave-alt"></i> <?=lang('home._page_c4_transaction');?> </a>
 


                </div>
            </li>            
            


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-truck"></i>
                    <span><?=lang('home._crud_c4_stock_movement');?> </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header"><?=lang('home._crud_c4_stock_movement');?> </h6>    

                    
            <a class="dropdown-item" href="<?=financepanel_url('c4_stock_movement/inflow_stock_movement');?>"><i class="fas fa-truck"></i> <?=lang('home._page_inflow_stock_movement');?> </a>

            <a class="dropdown-item" href="<?=financepanel_url('c4_stock_movement/outflow_stock_movement');?>"><i class="fas fa-truck-monster"></i> <?=lang('home._page_outflow_stock_movement');?> </a>
 


                </div>
            </li>            
            