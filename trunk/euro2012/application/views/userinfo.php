<?php
// File: /system/application/views/userinfo.php
// Version: 1.0
// Author: Schop 
?>
    <h3>Edit User Info</h3>

    <?php echo form_open('user_info/submit'); ?>

    <?php echo validation_errors('<p class="error">','</p>'); ?>
    
    <?php echo form_hidden('id',$user->id); ?>            
        <p>
            <label for="username">User name:</label>
           
            <?php echo form_input('username',$user->username); ?>
        </p>
        <p>
            <label for="nickname">Nick name:</label>
           
            <?php echo form_input('nickname',$user->nickname); ?>
        </p>
	    <p>
		    <label for="password">Password: </label>
          
		    <?php echo form_password('password'); ?>
	    </p>
	    <p>
		    <label for="passconf">Confirm Password: </label>
            
		    <?php echo form_password('passconf'); ?>
	    </p>
	    <p>
		    <label for="email">E-mail: </label>
           
		    <?php echo form_input('email',$user->email); ?>
	    </p>
	    <p>
		    <label for="street">Adress: </label>
          
		    <?php echo form_input('street',$user->street); ?>
	    </p>
	    <p>
		    <label for="zip">Zipcode: </label>
           
		    <?php echo form_input('zip',$user->zipcode); ?>
        </p>
        <p>
		    <label for="city">City: </label>
            
		    <?php echo form_input('city',$user->city); ?>
	    </p>
	    <p>
		    <label for="phone">Phone: </label>
           
		    <?php echo form_input('phone',$user->phone); ?>
	    </p>	    

    <p class='buttons'>
	    <?php echo form_submit('submit','Save'); ?>
	    <?php echo anchor('/','<img src="'.base_url().'images/icons/cross.png" alt="" />Cancel', 'class="negative"'); ?>
    </p>
    <?php echo form_close(); ?>
