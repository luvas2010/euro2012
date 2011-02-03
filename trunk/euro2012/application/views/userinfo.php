<?php
// File: /system/application/views/userinfo.php
// Version: 1.0
// Author: Schop 
$this->lang->load('user', language());
?>
    <h3><?php echo $this->lang->line('Edit_User_Info');?></h3>

    <?php echo form_open('user_info/submit'); ?>

    <?php echo validation_errors('<p class="error">','</p>'); ?>
    
    <?php echo form_hidden('id',$user->id); ?>            
        <p>
            <label for="username"><?php echo $this->lang->line('User_name:');?></label>
           
            <?php echo form_input('username',$user->username); ?>
        </p>
        <p>
            <label for="nickname"><?php echo $this->lang->line('Nick_name:');?></label>
           
            <?php echo form_input('nickname',$user->nickname); ?>
        </p>
	    <p>
		    <label for="password"><?php echo $this->lang->line('Password:');?></label>
          
		    <?php echo form_password('password'); ?>
	    </p>
	    <p>
		    <label for="passconf"><?php echo $this->lang->line('Confirm_Password:');?></label>
            
		    <?php echo form_password('passconf'); ?>
	    </p>
        <p>
            <label for="language"><?php echo $this->lang->line('Language:');?></label>
            <?php $languages = Array('english' => 'english',
                                     'nederlands' =>  'nederlands'); ?>
            <?php echo form_dropdown('language',$languages, 'english');?>
        <p>        
	    <p>
		    <label for="email"><?php echo $this->lang->line('E-mail:');?></label>
           
		    <?php echo form_input('email',$user->email); ?>
	    </p>
	    <p>
		    <label for="street"><?php echo $this->lang->line('Adress:');?></label>
          
		    <?php echo form_input('street',$user->street); ?>
	    </p>
	    <p>
		    <label for="zip"><?php echo $this->lang->line('Zipcode:');?></label>
           
		    <?php echo form_input('zip',$user->zipcode); ?>
        </p>
        <p>
		    <label for="city"><?php echo $this->lang->line('City:');?></label>
            
		    <?php echo form_input('city',$user->city); ?>
	    </p>
	    <p>
		    <label for="phone"><?php echo $this->lang->line('Phone:');?></label>
           
		    <?php echo form_input('phone',$user->phone); ?>
	    </p>	    

    <p class='buttons'>
	    <?php echo form_submit('submit',$this->lang->line('save')); ?>
	    <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />'.$this->lang->line('cancel'), 'class="negative"'); ?>
    </p>
    <?php echo form_close(); ?>
