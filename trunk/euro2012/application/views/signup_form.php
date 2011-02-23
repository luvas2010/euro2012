<div id="signup_form">

	<p class="heading">New User Signup</p>

	<?php echo form_open('signup/submit'); ?>

	<?php echo validation_errors('<div class="error">','</div>'); ?>

	<p>
		<label for="username">Username: </label>
		<?php echo form_input('username',set_value('username')); ?>
	</p>
	<p>
		<label for="nickname">Nickname: </label>
		<?php echo form_input('nickname',set_value('nickname')); ?>
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
		<?php echo form_input('email',set_value('email')); ?>
	</p>
    <p>
        <label for="language">Language: </label>
        <?php $languages = Array('english' => 'english',
                                 'nederlands' =>  'nederlands'); ?>
        <?php echo form_dropdown('language',$languages, 'english');?>
	<p>
		<label for="street">Adress: </label>
		<?php echo form_input('street',set_value('street')); ?>
	</p>
	<p>
		<label for="city">City: </label>
		<?php echo form_input('city',set_value('city')); ?>
	</p>
	<p>
		<label for="phone">Phone: </label>
		<?php echo form_input('phone',set_value('phone')); ?>
	</p>
	<p class='buttons'>
		<?php echo form_submit('submit','Create my account'); ?>
	</p>
	<?php echo form_close(); ?>
  	<p>
        	<?php echo anchor('login','Login Form'); ?>
	</p>

</div>

