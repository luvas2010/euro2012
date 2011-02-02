<?php
// File: /system/application/views/settings.php
// Version: 1.0
// Author: Schop 
$this->lang->load('set', 'nederlands');
?>
        <h3><?php echo $this->lang->line('edit_settings');?></h3>
        
	    <?php echo form_open('settings_admin/submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
	    <table>
	        <thead>
	            <tr>
	                <th><?php echo $this->lang->line('setting');?></th>
	                <th><?php echo $this->lang->line('value');?></th>
                    <th><?php echo $this->lang->line('description');?></th>
	            </tr>
	        </thead>
	        <tbody>
        <?php foreach ($settings_ad as $setting): ?>
		    <tr>
		    <?php echo form_hidden('id'.$setting->id,$setting->id); ?>            
	            <td>
	                <label for="value<?php echo $setting->id; ?>"><?php echo $this->lang->line($setting->setting);?>:</label>
		        </td>
		        <td>
		            <?php echo form_input('value'.$setting->id,$setting->value); ?>
	            </td>
	            <td>
		            <?php echo $this->lang->line($setting->description); ?>
	            </td>
	        </tr>
	<?php endforeach; ?>
	    </tbody>
    </table>
    <p class='buttons'>
	    <?php echo form_submit('submit',$this->lang->line('save')); ?>
	    <?php echo anchor('/','<img src="images/icons/cross.png" alt="" />'.$this->lang->line('cancel'), 'class="negative"'); ?>
    </p>
    <?php echo form_close(); ?>
