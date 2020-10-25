<?php

$url = financepanel_url('user/save/user51988274');
$hiddenArray = [];

if( !empty($formData['user_id']) )
{
    $url .= '/' . $formData['user_id'];
        
    $hiddenArray['_method'] = "PUT";
}

$form_attr = 'id="user51988274" autocomplete="off" role="presentation" data-pageslug="user" data-formslug="user51988274"  data-jsname="user" data-modalsize="lg" data-packagelist="selectpicker,popover,uisortable,cropperjs" data-closeonsave="true" class="bg-white crud4form"';

echo form_open($url, $form_attr, $hiddenArray); 
?>

<?=form_input("_formSlug", $formData['_formSlug'] ?? "user51988274", '', 'hidden');?> 
<?=form_input("_pageSlug", $formData['_pageSlug'] ?? "user", '', 'hidden');?> 
<?=form_input("user_id", $formData['user_id'] ?? "", '', 'hidden');?> 

<div class="modal-header">
    <h5 class="modal-title" id=""><i class="fas fa-user"></i> <?=lang('user._form_user51988274'); ?> </h5>
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

         <div class="form-group" id="groupField_firstname">
            <label for="firstname" class="required col-form-label"> <?=lang('user.firstname'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("firstname", $formData['firstname'] ?? '', ' id="firstname" class="form-control" required maxlength="32" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
        <div class="col">

         <div class="form-group" id="groupField_lastname">
            <label for="lastname" class="required col-form-label"> <?=lang('user.lastname'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("lastname", $formData['lastname'] ?? '', '  id="lastname" class="form-control" required maxlength="32" ', 'text'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_email">
            <label for="email" class="required col-form-label"> <?=lang('user.email'); ?></label>
            
                                <div class="input-group">
                        
                        <?php
                        echo form_input("email", $formData['email'] ?? '', ' id="email" class="form-control" required maxlength="96" ', 'email'); 
                        ?>
                        
                    </div>
                    

        </div>
        </div>
    </div>

    

    <div class="form-row">
        <div class="col">

         <div class="form-group" id="groupField_avatar">
            <label for="avatar" class="permit_empty col-form-label"> <?=lang('user.avatar'); ?></label>
            
            
<div class="input-group">
    <?php
    $def = resources_url('images/empty.png');
    $randomID = rand(10000, 99999);

    if (!empty($formData['avatar']))
    {
        $fileService = \Financepanel\Config\Services::file();
        $file = $fileService->getFile($formData['avatar']);

        if (!empty($file))
        {
            // $def = getThumbFromData($file);
            $def = $file['url_thumb'];
        }
    }

    ?>

    <label class="label labelcropper" data-toggle="tooltip" title="<?=lang("user.avatar_helpText")?>" style="cursor: pointer;">
        <img class="rounded cropper_img img-thumbnail float-left" id="cropper_img_<?=$randomID;?>" src="<?=$def;?>" alt="avatar" style="max-width: 90px;"/>
        <input type="file" name="file" accept="image/*" class="sr-only cropperjs" id="input_<?=$randomID;?>" 
            data-action="<?=financepanel_url("user/uploadFile/user51988274/avatar");?>" data-inputname="avatar" data-idnumber="<?=$randomID;?>" 
            data-isrounded="" data-maxw="220" data-maxh="220" 
           data-minw="220" data-minh="220" data-fixedcropbox="">
    </label>
   
    <?php echo form_input("avatar", $formData['avatar'] ?? '', '', 'hidden'); ?>

</div>

<div class="progress cropper_progress" id="progress_<?=$randomID;?>" style="display:none">
    <div id="progressbar_<?=$randomID;?>" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
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