<h2><?php echo $title; ?></h2>
<div id='install'>
    <div class='success'>
        <h3>De tabellen zijn aangemaakt voor de volgende data-modellen:</h3>
            <ul>
            <?php $this->load->database(); foreach ($models as $k => $table): ?>
                <li><?php echo $table; ?></li>
            <?php endforeach; ?>
            </ul>
    </div>
    <h3>Maak nu de eerste gebruiker aan.</h3>
    <p>Deze gebruiker wordt automatisch geaktiveerd, en heeft administrator rechten.</p>
    <?php echo form_open('install/first_user'); ?>
    <?php echo validation_errors('<div class="error">','</div>'); ?>
	<p class="wide">
		<label for="username">Gebruikersnaam: </label>
		<?php echo form_input('username',set_value('username')); ?>
	</p>
	<p class="wide">
		<label for="nickname">Nickname: </label>
		<?php echo form_input('nickname',set_value('nickname')); ?>
	</p>
	<p class="wide">
		<label for="password">Wachtwoord: </label>
		<?php echo form_password('password'); ?>
	</p>
	<p class="wide">
		<label for="passconf">Wachtwoord bevestigen: </label>
		<?php echo form_password('passconf'); ?>
	</p>
	<p class="wide">
		<label for="email" class="wide">E-mail: </label>
		<?php echo form_input('email',set_value('email')); ?>
	</p>
    <p class='buttons'>
		<?php echo form_submit('submit','Aanmaken, en verder naar stap 3'); ?>
	</p>
	<?php echo form_close(); ?>
	        
</div>
