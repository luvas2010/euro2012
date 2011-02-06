<?php
// File: /system/application/views/textedit.php
// Version: 1.0
// Author: Schop
// revisions:


$this->lang->load('user', language());
?>
    <h3>Edit text <?php echo $text['text_name']; ?></h3>

    <?php echo form_open('text/submit'); ?>

        <?php echo validation_errors('<p class="error">','</p>'); ?>
    
        <?php echo form_hidden('id',$text['id']); ?>            
        <p><label for="text_english">English version</label></p>
        <p><?php echo form_textarea('text_english',$text['text_en'],"class='ckeditor'"); ?></p>
        <p><label for="text_nederlands">Nederlandse versie</label></p>
        <p><?php echo form_textarea('text_nederlands',$text['text_nl'], "class='ckeditor'"); ?></p>


        <p class='buttons'>
            <?php echo form_submit('submit',lang('save')); ?>
            <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />'.lang('cancel'), 'class="negative"'); ?>
        </p>
    <?php echo form_close(); ?>
