<?php
$tableTitle = lang('contact._page_contact');
?>



<div class="card border-light mb-0">
    <div  class="card-header bg-transparent">
        <div class="float-left text-center">
            <h5 class=""><i class="far fa-building"></i> <?=$tableTitle; ?> &nbsp; <small><span class="date_title"></span></small></h5>
        </div>

        <!-- begin: Form Buttons -->
        <ul class="nav nav-pills card-header-pills float-right">
           
            <?php
            $encoded   = '';
            $url       = financepanel_url('contact/showForm/contact');           

            //If this page loaded inside antother page, You may want to $extraCondition array to link
            if(isset($extraCondition) && is_array($extraCondition)){
                $encoded = json_encode($extraCondition);
            }               
            ?>

                        <li class="nav-item">
                            <a class="nav-link  btn btn-sm btn-primary mr-1" 
                               href="<?=$url;?>" 
                               data-modalsize="lg"
                               data-datatable="table_contact"
                               data-modalurl="<?=$url;?>"
                               data-modaldata='<?=$encoded;?>'
                               data-modalview='centermodal'
                               data-modalbackdrop='true'
                               data-action="openformmodal">
                                <span>
                                    <i class="far fa-building"></i>
                                    <span><?=lang('contact._form_contact'); ?></span>
                                </span>
                            </a>
                        </li>

                        
            
            
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-primary mr-1 dropdown-toggle" data-toggle="collapse" href="#searchFormArea_contact" aria-controls="searchFormArea_contact" aria-expanded="false">
                        <i class='fa fa-search'></i>
                    </a>
                </li>


        </ul>
        <!-- end: Form Buttons -->

    </div>
    <div class="card-body mb-0 pt-0">


        <!--begin: Search Form -->
        <div class="collapse p-1" id="searchFormArea_contact">
            <div class="card card-body border-light p-0">

<?php echo form_open(financepanel_url('contact/readContact/contact'), 'id="form_contact"'); ?>
                
                
                <?php
                //If this page loaded Other PAge You mAy want to $extraCondition array to filter
                //
                if(isset($extraCondition) && is_array($extraCondition)){
                    echo form_hidden($extraCondition);
                }               
                ?>         

                <div class="form-row">

                                <!--  contact_type -->
                                <div class="form-group col-md-2 col-sm-6">
                                    <label><?=lang('contact.contact_type'); ?></label>
                                                
                                    <?php
                                    $option_list = lang('contact.list_contact_type');
                                    ?>                                       
                                    <?php
                                    $option_list = ['' => lang('home.all')] + $option_list;
                                    ?>                                       <?php
                                    echo form_dropdown("contact_type", $option_list, '',  ' class="form-control selectpicker formSearch"');
                                    ?>

                                    <span class="m-form__help"></span>
                                </div>

                                     

                    
                        <!--  General Search -->           
                        <div class="form-group col-md-2">
                            <label><?php echo lang('home.general_search'); ?></label>
    
                        <?php $searchText = lang("contact.name"). ', ' .lang("contact.email"). ', ' .lang("contact.fax"); ?>

                            <input type="search"  name="filterSearch" class="form-control generalSearch" placeholder="<?= $searchText; ?>" />

                        </div>


                </div>

                    <?php echo form_close(); ?>
            </div>
        </div>
        <!--end: Search Form -->

        <!-- begin: Batch Processing -->
        <div class="collapse batchProcessing" id="batch_contact">

            <div class="card border-light card-body mb-0">

                <div class="btn-group btn-group-sm" role="group" aria-label="Button group with nested dropdown">



                                <!--  contact_type -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('contact.contact_type'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('contact/update');?>"
                                               data-datatable="table_contact" data-jsname="contact"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("contact.contact_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"contact_type":"company"}'><?=lang('contact.list_contact_type')['company'] ?? 'company'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('contact/update');?>"
                                               data-datatable="table_contact" data-jsname="contact"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("contact.contact_type");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"contact_type":"person"}'><?=lang('contact.list_contact_type')['person'] ?? 'person'; ?></a>

                
                                    </div>
                                </div>

            
                                <!--  status -->
                                <div class="btn-group btn-group-sm ml-2" role="group">
                                    <button id="btnGroupDrop1" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?=lang('contact.status'); ?> &nbsp; <span class="badge badge-light selectedCount">0</span>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                        
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('contact/update');?>"
                                               data-datatable="table_contact" data-jsname="contact"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("contact.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"1"}'><?=lang('contact.list_status')['1'] ?? '1'; ?></a>

                
                                            <a class="dropdown-item" href="#"
                                               data-action="show_dt_replace"
                                               data-actionurl= "<?=financepanel_url('contact/update');?>"
                                               data-datatable="table_contact" data-jsname="contact"
                                               data-question="<?=lang("home.areyousure");?>"
                                               data-subtitle="<b><?=lang("contact.status");?></b> <?=lang("home.will_be_updated");?> "
                                               data-processingtitle="<?=lang("home.processing");?>" 
                                               data-postdata='{"status":"2"}'><?=lang('contact.list_status')['2'] ?? '2'; ?></a>

                
                                    </div>
                                </div>

            
                    
                    <div class="btn-group btn-group-sm ml-2 delete_link" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=financepanel_url('contact/update');?>"
                        data-datatable="table_contact"  data-jsname="contact"
                        data-question="<?=lang("home.areyousure");?>"
                        data-subtitle="<?=lang("home.will_be_deleted");?>"
                        data-processingtitle="<?=lang("home.deleted");?>" 
                        data-postdata='{"deleted_at":"1"}'
                        ><?= lang('home.delete'); ?>&nbsp; <span class="badge badge-light selectedCount">0</span>
                        </a>
                    </div>

                    <div class="btn-group btn-group-sm ml-2 undelete_link" style="display:none" role="group">
                        <a class="btn btn-sm btn-danger ml-1" href="#"
                        data-action="show_dt_replace"
                        data-actionurl= "<?=financepanel_url('contact/update');?>"
                        data-datatable="table_contact"  data-jsname="contact"
                        data-question="<?=lang("home.areyousure");?>"
                        data-subtitle="<?=lang("home.will_be_restored");?>"
                        data-processingtitle="<?=lang("home.restoring");?>" 
                        data-postdata='{"deleted_at":"0"}'
                        ><?= lang('home.restore'); ?>&nbsp; <span class="badge badge-light selectedCount">0</span>
                        </a>
                    </div>
             



                    
                    <div class="btn-group btn-group-sm ml-2"  role="group">            
                        <a href="#" 
                            data-modalsize="lg" 
                            data-datatable="table_contact" 
                            data-modalurl="<?=financepanel_url('home/showForm/email');?>" 
                            data-modaldata='{"type":"multiple", "table_name":"contact", "email_field":"email", "datatable":"table_contact", "jsname":"contact"}' 
                            data-action="openformmodal" 
                            class="btn btn-sm btn-primary"> <i class="fas fa-envelope-open-text"></i> Multi Emailing <span class="badge badge-light selectedCount">0</span> (<?=lang("contact.email");?>)
                        </a>
                    </div>                    


                </div>


            </div>

        </div>
        <!-- end: Batch Processing -->



            <div class="table-responsive">
                <table id="table_contact" class="table table-hover" width="100%" cellspacing="0" data-url="<?=financepanel_url('contact/readContact/contact');?>"></table>
            </div>





    </div>
</div>


<script src="<?= financepanel_url('contact/langJS');?>"></script>

    <script src="<?= site_url('assets/financepanel/contact/contact.js');?>"></script> 

    



            <script src="<?= financepanel_url('c4_invoice/langJS'); ?>"></script>

            
            <script src="<?= financepanel_url('c4_invoice/langJS'); ?>"></script>

            