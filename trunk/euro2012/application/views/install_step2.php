<h2><?php echo $title; ?></h2>
<div id='install'>
    <div class='success'>
        <h3>Tables were created for data models:</h3>
            <ul>
            <?php $this->load->database(); foreach ($models as $k => $table): ?>
                <li><?php echo $table; ?></li>
            <?php endforeach; ?>
            </ul>
    </div>
    <h3>Create the first user (administrator)</h3>
    <?php echo form_open('install/first_user'); ?>
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
	   <label for="play">Does the admin play the game? </label>
	   <?php echo form_checkbox('play', 'play', true); ?>
	</p>
    <p>
		<?php echo form_submit('submit','Create my account'); ?>
	</p>
	<?php echo form_close(); ?>
	        
</div>
