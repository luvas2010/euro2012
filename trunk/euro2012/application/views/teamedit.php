 <?php
// File: /system/application/views/teamedit.php
// Version: 1.0
// Author: Schop 
?>
       <h3>Edit Team Details</h3>
        
	    <?php echo form_open('team/submit'); ?>

	    <?php echo validation_errors('<p class="error">','</p>'); ?>
        
		    <?php echo form_hidden('id',$team[0]->id); ?>            
	        <p>
	            <label for="teamname">Team name:</label>
                <?php echo form_input('teamname',$team[0]->name); ?>
	        </p>
	        <p>
	            <label for="teamflag">Team flag:</label>
                <?php echo form_input('teamflag',$team[0]->flag); ?>
            </p>
            <p>
	            <label for="shortname">Short name:</label>
                <?php echo form_input('shortname',$team[0]->shortname); ?>
            </p>
        <p class='buttons'>
	        <?php echo form_submit('submit','Save'); ?>
	        <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
        </p>
        <?php echo form_close(); ?>
