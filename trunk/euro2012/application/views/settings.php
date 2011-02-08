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
                    <th>Delete</th>
	            </tr>
	        </thead>
	        <tbody>
        <?php foreach ($settings_ad as $setting): ?>
		    <tr>
		    <?php echo form_hidden('id'.$setting['id'],$setting['id']); ?>            
	            <td>
	                <label for="value<?php echo $setting['id']; ?>"><?php echo $setting['setting'];?>:</label>
		        </td>
		        <td>
		            <?php echo form_input('value'.$setting['id'],$setting['value']); ?>
	            </td>
	            <td>
		            <?php echo $setting['description']; ?>
	            </td>
                <td class="buttons"><?php echo anchor ('settings_admin/delete/'.$setting['id'], "Deze&nbsp;instelling&nbsp;verwijderen");?></td>
	        </tr>
	<?php endforeach; ?>
	    </tbody>
    </table>
    <p class='buttons'>
	    <?php echo form_submit('submit',lang('save')); ?>
	    <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />'.lang('cancel'), 'class="negative"'); ?>
    </p>
    <?php echo form_close(); ?>
    <br /><hr />
	<?php echo form_open('settings_admin/add_setting_submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
        <h3>Voeg een parameter toe</h3>
	    <table>
	        <thead>
	            <tr>
	                <th><?php echo lang('setting');?></th>
	                <th><?php echo lang('value');?></th>
                    <th><?php echo lang('description');?></th>
	            </tr>
	        </thead>
	        <tbody>
		    <tr>            
	            <td>
	                <?php echo form_input('setting',''); ?>
		        </td>
		        <td>
		            <?php echo form_input('value',''); ?>
	            </td>
	            <td>
		            <?php echo form_input('description','', 'size="80"'); ?>
	            </td>
	        </tr>
	    </tbody>
    </table>
    <p class='buttons'>
	    <?php echo form_submit('submit',lang('save')); ?>
	    <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />'.lang('cancel'), 'class="negative"'); ?>
    </p>
    <?php echo form_close(); ?>    
    