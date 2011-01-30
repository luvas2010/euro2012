<div id="signup_form">

	<p class="heading">User Login</p>

	<?php echo form_open('login/submit'); ?>

	<?php echo validation_errors('<p class="error">','</p>'); ?>

	<p>
		<label for="username">Username: </label>
		<?php echo form_input('username',set_value('username')); ?>
	</p>
	<p>
		<label for="password">Password: </label>
		<?php echo form_password('password'); ?>
	</p>
	<p class="buttons">
		<?php echo form_submit('submit','Login'); ?><?php echo anchor('signup','<img src="'.base_url().'images/icons/user_add.png" alt="" />Create a New Account'); ?>
	</p>

	<?php echo form_close(); ?>
	
</div>
