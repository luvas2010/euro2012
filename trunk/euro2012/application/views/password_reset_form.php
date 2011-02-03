<div id="password_form">

	<h3>Password Reset</h3>

	<?php echo form_open('user_info/reset_pass_submit'); ?>

	<?php echo validation_errors('<p class="error">','</p>'); ?>

	<p>If you forgot your password, please give us the e-mail address you gave when you registered. You will receive an e-mail with a link to set a new password</p>
    <p>
		<label for="email">E-mail: </label>
		<?php echo form_input('email',set_value('email')); ?>
	</p>
        
	<p class="buttons">
		<?php echo form_submit('submit','Send'); ?>
	</p>

	<?php echo form_close(); ?>
	
</div>
