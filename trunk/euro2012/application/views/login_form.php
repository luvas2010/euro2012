<div id="signup_form">

	<h2>Gebruiker Login</h2>

	<?php echo form_open('login/submit'); ?>

	<?php echo validation_errors('<p class="error">','</p>'); ?>

	<p>
		<label for="username">Gebruikers naam: </label>
		<?php echo form_input('username',set_value('username')); ?>
	</p>
	<p>
		<label for="password">Wachtwoord: </label>
		<?php echo form_password('password'); ?>
	</p>
	<p class="buttons">
		<?php echo form_submit('submit','Login'); ?>
        <?php echo anchor('user_info/reset_password','<img src="'.base_url().'images/icons/exclamation.png" alt="" />Wachtwoord vergeten?'); ?>
    </p>
    <p>
        <?php echo anchor('signup','<img src="'.base_url().'images/icons/user_add.png" alt="" />Maak een nieuwe gebruiker aan'); ?>
	</p>

	<?php echo form_close(); ?>
	
</div>
