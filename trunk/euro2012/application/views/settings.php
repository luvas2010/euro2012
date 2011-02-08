<?php
// File: /system/application/views/settings.php
// Version: 1.0
// Author: Schop 
// fetch language file
$this->lang->load('set', language() );

?>
        <h3><?php echo lang('edit_settings');?></h3>
        
	    <?php echo form_open('settings_admin/submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
	    <table>
	        <thead>
	            <tr>
	                <th><?php echo lang('setting');?></th>
	                <th><?php echo lang('value');?></th>
                    <th><?php echo lang('description');?></th>
	            </tr>
	        </thead>
	        <tbody>
        <?php foreach ($settings_ad as $setting): ?>
		    <tr>
		    <?php echo form_hidden('id'.$setting->id,$setting->id); ?>            
	            <td>
	                <label for="value<?php echo $setting->id; ?>"><?php echo $setting['setting'];?>:</label>
		        </td>
		        <td>
		            <?php echo form_input('value'.$setting['id'],$setting['value']); ?>
	            </td>
	            <td>
		            <?php echo lang($setting['description']); ?>
	            </td>
	        </tr>
	<?php endforeach; ?>
	    </tbody>
    </table>
    <p class='buttons'>
	    <?php echo form_submit('submit',lang('save')); ?>
	    <?php echo anchor('/','<img src="images/icons/cross.png" alt="" />'.lang('cancel'), 'class="negative"'); ?>
    </p>
    <?php echo form_close(); ?>
